<?php

namespace QR_Code\Encoder;

use QR_Code\QR_Code;
use QR_Code\Util\Benchmark;
use QR_Code\Util\Logger;
use QR_Code\Util\Tools;

/**
 * Class Encoder
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Encoder
 */
class Encoder
{
    public $caseSensitive = true;
    public $eightBit      = false;

    public $version   = 0;
    public $size      = 3;
    public $margin    = 4;
    public $backColor = QR_WHITE;
    public $foreColor = QR_BLACK;
    public $cmyk      = false;

    public $structured = 0; // not supported yet

    public $level = QR_ECLEVEL_L;
    public $hint  = QR_MODE_8;

    /**
     * @param int|string $level
     * @param int        $size
     * @param int        $margin
     * @param int        $backColor
     * @param int        $foreColor
     * @param bool       $cmyk
     * @return \QR_Code\Encoder\Encoder
     */
    public static function factory ($level = QR_ECLEVEL_L, int $size = 3, int $margin = 4, int $backColor = QR_WHITE, int $foreColor = QR_BLACK, bool $cmyk = false) : Encoder
    {
        $enc = new self();
        $enc->size = $size;
        $enc->margin = $margin;
        $enc->foreColor = $foreColor;
        $enc->backColor = $backColor;
        $enc->cmyk = $cmyk;

        switch ($level . '') {
            case '0':
            case '1':
            case '2':
            case '3':
                $enc->level = $level;
                break;
            case 'l':
            case 'L':
                $enc->level = QR_ECLEVEL_L;
                break;
            case 'm':
            case 'M':
                $enc->level = QR_ECLEVEL_M;
                break;
            case 'q':
            case 'Q':
                $enc->level = QR_ECLEVEL_Q;
                break;
            case 'h':
            case 'H':
                $enc->level = QR_ECLEVEL_H;
                break;
        }

        return $enc;
    }

    /**
     * @param string      $inText
     * @param string|bool $outfile
     * @return mixed
     * @throws \Exception
     */
    public function encodeRAW (string $inText, $outfile = false)
    {
        $code = new QR_Code();

        if ($this->eightBit) {
            $code->encodeString8bit($inText, $this->version, $this->level);
        } else {
            $code->encodeString($inText, $this->version, $this->level, $this->hint, $this->caseSensitive);
        }

        if ($outfile !== false) {
            file_put_contents($outfile, join("\n", Tools::binarize($code->data)));
        }

        return $code->data;
    }

    /**
     * @param string      $inText  Information to encode
     * @param bool|string $outfile filename to save encoded data
     * @return array Encoded Array
     * @throws \Exception
     */
    public function encode (string $inText, $outfile = false) : array
    {
        $code = new QR_Code();

        if ($this->eightBit) {
            $code->encodeString8bit($inText, $this->version, $this->level);
        } else {
            $code->encodeString($inText, $this->version, $this->level, $this->hint, $this->caseSensitive);
        }

        Benchmark::mark('after_encode');

        if ($outfile !== false) {
            file_put_contents($outfile, join("\n", Tools::binarize($code->data)));

        }

        return Tools::binarize($code->data);
    }

    /**
     * @param string      $inText
     * @param string|bool $outfile
     * @param bool        $saveAndPrint
     */
    public function encodePNG (string $inText, $outfile = false, $saveAndPrint = false) : void
    {
        try {

            ob_start();
            $tab = $this->encode($inText);
            $err = ob_get_contents();
            ob_end_clean();

            if ($err != '') Logger::log($outfile, $err);

            $maxSize = (int) (QR_PNG_MAXIMUM_SIZE / (count($tab) + 2 * $this->margin));

            Image::png($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin, $saveAndPrint, $this->backColor, $this->foreColor);

        } catch (\Exception $e) {

            Logger::log($outfile, $e->getMessage());

        }
    }

    /**
     * @param string      $inText
     * @param string|bool $outfile
     * @param bool        $saveAndPrint
     */
    public function encodeEPS (string $inText, $outfile = false, $saveAndPrint = false) : void
    {
        try {

            ob_start();
            $tab = $this->encode($inText);
            $err = ob_get_contents();
            ob_end_clean();

            if ($err != '') Logger::log($outfile, $err);

            $maxSize = (int) (QR_PNG_MAXIMUM_SIZE / (count($tab) + 2 * $this->margin));

            Vector::eps($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin, $saveAndPrint, $this->backColor, $this->foreColor, $this->cmyk);

        } catch (\Exception $e) {

            Logger::log($outfile, $e->getMessage());

        }
    }

    /**
     * @param string      $inText
     * @param string|bool $outfile
     * @param bool        $saveAndPrint
     */
    public function encodeSVG (string $inText, $outfile = false, $saveAndPrint = false) : void
    {
        try {

            ob_start();
            $tab = $this->encode($inText);
            $err = ob_get_contents();
            ob_end_clean();

            if ($err != '') Logger::log($outfile, $err);

            $maxSize = (int) (QR_PNG_MAXIMUM_SIZE / (count($tab) + 2 * $this->margin));

            Vector::svg($tab, $outfile, min(max(1, $this->size), $maxSize), $this->margin, $saveAndPrint, $this->backColor, $this->foreColor);

        } catch (\Exception $e) {

            Logger::log($outfile, $e->getMessage());

        }
    }
}