<?php

namespace QR_Code;

use QR_Code\Config\Specifications;
use QR_Code\Encoder\Encoder;
use QR_Code\Encoder\Input;
use QR_Code\Encoder\Mask;
use QR_Code\Encoder\RawCode;
use QR_Code\Util\Benchmark;
use QR_Code\Util\FrameFiller;
use QR_Code\Util\Split;

/**
 * Class QR_Code
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 *
 * @package QR_Code
 */
class QR_Code
{
    public $version;
    public $width;
    public $data;

    /**
     * @param \QR_Code\Encoder\Input $input
     * @param  mixed                 $mask
     * @return $this|null
     * @throws \Exception
     */
    public function encodeMask (Input $input, $mask)
    {
        if ($input->getVersion() < 0 || $input->getVersion() > QRSPEC_VERSION_MAX) {
            throw new \Exception('wrong version');
        }
        if ($input->getErrorCorrectionLevel() > QR_ECLEVEL_H) {
            throw new \Exception('wrong level');
        }

        $raw = new RawCode($input);

        Benchmark::mark('after_raw');

        $version = $raw->version;
        $width = Specifications::getWidth($version);
        $frame = Specifications::newFrame($version);

        $filler = new FrameFiller($width, $frame);
        if (is_null($filler)) {
            return null;
        }

        // inteleaved data and ecc codes
        for ($i = 0; $i < $raw->dataLength + $raw->eccLength; $i++) {
            $code = $raw->getCode();
            $bit = 0x80;
            for ($j = 0; $j < 8; $j++) {
                $addr = $filler->next();
                $filler->setFrameAt($addr, 0x02 | (($bit & $code) != 0));
                $bit = $bit >> 1;
            }
        }

        Benchmark::mark('after_filler');

        unset($raw);

        // remainder bits
        $j = Specifications::getRemainder($version);
        for ($i = 0; $i < $j; $i++) {
            $addr = $filler->next();
            $filler->setFrameAt($addr, 0x02);
        }

        $frame = $filler->frame;
        unset($filler);


        // masking
        $maskObj = new Mask();
        if ($mask < 0) {

            if (QR_FIND_BEST_MASK) {
                $masked = $maskObj->mask($width, $frame, $input->getErrorCorrectionLevel());
            } else {
                $masked = $maskObj->makeMask($width, $frame, (intval(QR_DEFAULT_MASK) % 8), $input->getErrorCorrectionLevel());
            }
        } else {
            $masked = $maskObj->makeMask($width, $frame, $mask, $input->getErrorCorrectionLevel());
        }

        if ($masked == null) {
            return null;
        }

        Benchmark::mark('after_mask');

        $this->version = $version;
        $this->width = $width;
        $this->data = $masked;

        return $this;
    }

    /**
     * @param \QR_Code\Encoder\Input $input
     * @return null|\QR_Code\QR_Code
     * @throws \Exception
     */
    public function encodeInput (Input $input)
    {
        return $this->encodeMask($input, -1);
    }

    /**
     * @param string     $string
     * @param int        $version
     * @param string|int $level
     * @return null|\QR_Code\QR_Code
     * @throws \Exception
     */
    public function encodeString8bit (string $string, int $version, $level)
    {
        if ($string == null) {
            throw new \Exception('empty string!');
        }

        $input = new Input($version, $level);
        if ($input == null) return null;

        $ret = $input->append(QR_MODE_8, strlen($string), str_split($string));

        if ($ret < 0) {
            unset($input);
            return null;
        }

        return $this->encodeInput($input);
    }

    /**
     * @param string     $string
     * @param int        $version
     * @param string|int $level
     * @param int        $hint
     * @param bool       $caseSensitive
     * @return null|\QR_Code\QR_Code
     * @throws \Exception
     */
    public function encodeString (string $string, int $version, $level, int $hint, bool $caseSensitive)
    {
        if ($hint != QR_MODE_8 && $hint != QR_MODE_KANJI) {
            throw new \Exception('bad hint');
        }

        $input = new Input($version, $level);
        if ($input == null) return null;

        $ret = Split::splitStringToQRinput($string, $input, $hint, $caseSensitive);

        if ($ret < 0) {
            return null;
        }

        return $this->encodeInput($input);
    }

    /**
     * @param  string     $text
     * @param string|bool $outfile
     * @param string|int  $level
     * @param int         $size
     * @param int         $margin
     * @param bool        $saveAndPrint
     * @param int         $back_color
     * @param int         $fore_color
     */
    public static function png (string $text, $outfile = false, $level = QR_ECLEVEL_L, int $size = 3, int $margin = 4, bool $saveAndPrint = false, int $back_color = QR_WHITE, int $fore_color = QR_BLACK) : void
    {
        $enc = Encoder::factory($level, $size, $margin, $back_color, $fore_color);
        $enc->encodePNG($text, $outfile, $saveAndPrint);
    }

    /**
     * @param      $text
     * @param bool $outfile
     * @param int  $level
     * @param int  $size
     * @param int  $margin
     * @return array
     * @throws \Exception
     */
    public static function text (string $text, $outfile = false, $level = QR_ECLEVEL_L, int $size = 3, int $margin = 4) : array
    {
        $enc = Encoder::factory($level, $size, $margin);
        return $enc->encode($text, $outfile);
    }

    /**
     * @param  string     $text
     * @param string|bool $outfile
     * @param string|int  $level
     * @param int         $size
     * @param int         $margin
     * @param bool        $saveAndPrint
     * @param int         $back_color
     * @param int         $fore_color
     * @param bool        $cmyk
     */
    public static function eps (string $text, $outfile = false, $level = QR_ECLEVEL_L, int $size = 3, int $margin = 4, bool $saveAndPrint = false, int $back_color = QR_WHITE, int $fore_color = QR_BLACK, bool $cmyk = false) : void
    {
        $enc = Encoder::factory($level, $size, $margin, $back_color, $fore_color, $cmyk);
        $enc->encodeEPS($text, $outfile, $saveAndPrint);
    }

    /**
     * @param string      $text
     * @param string|bool $outfile
     * @param string|int  $level
     * @param int         $size
     * @param int         $margin
     * @param bool        $saveAndPrint
     * @param int         $back_color
     * @param int         $fore_color
     */
    public static function svg (string $text, $outfile = false, $level = QR_ECLEVEL_L, int $size = 3, int $margin = 4, bool $saveAndPrint = false, int $back_color = QR_WHITE, int $fore_color = QR_BLACK) : void
    {
        $enc = Encoder::factory($level, $size, $margin, $back_color, $fore_color);
        $enc->encodeSVG($text, $outfile, $saveAndPrint);
    }

    /**
     * @param string      $text
     * @param string|bool $outfile
     * @param int         $level
     * @param int         $size
     * @param int         $margin
     * @return mixed
     * @throws \Exception
     */
    public static function raw (string $text, $outfile = false, int $level = QR_ECLEVEL_L, int $size = 3, int $margin = 4)
    {
        $enc = Encoder::factory($level, $size, $margin);
        return $enc->encodeRAW($text, $outfile);
    }
}