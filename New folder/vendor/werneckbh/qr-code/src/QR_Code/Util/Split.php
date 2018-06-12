<?php

namespace QR_Code\Util;

use QR_Code\Config\Specifications;
use QR_Code\Encoder\Input;

/**
 * Class Split
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Util
 */
class Split
{
    /**
     * @var string
     */
    public $dataStr = '';
    /**
     * @var \QR_Code\Encoder\Input
     */
    public $input;
    /**
     * @var int
     */
    public $modeHint;

    /**
     * Split constructor.
     * @param           string       $dataStr
     * @param \QR_Code\Encoder\Input $input
     * @param int                    $modeHint
     */
    public function __construct (string $dataStr, Input $input, int $modeHint)
    {
        $this->dataStr = $dataStr;
        $this->input = $input;
        $this->modeHint = $modeHint;
    }

    /**
     * @param string $str
     * @param int    $pos
     * @return bool
     */
    public static function isDigitAt (string $str, int $pos) : bool
    {
        if ($pos >= strlen($str))
            return false;

        return ((ord($str[$pos]) >= ord('0')) && (ord($str[$pos]) <= ord('9')));
    }

    /**
     * @param string $str
     * @param int    $pos
     * @return bool
     */
    public static function isAlnumAt (string $str, int $pos) : bool
    {
        if ($pos >= strlen($str))
            return false;

        return (Input::lookAnTable(ord($str[$pos])) >= 0);
    }

    /**
     * @param int $pos
     * @return int
     */
    public function identifyMode (int $pos) : int
    {
        if ($pos >= strlen($this->dataStr))
            return QR_MODE_NUL;

        $c = $this->dataStr[$pos];

        if (self::isDigitAt($this->dataStr, $pos)) {
            return QR_MODE_NUM;
        } elseif (self::isAlnumAt($this->dataStr, $pos)) {
            return QR_MODE_AN;
        } elseif ($this->modeHint == QR_MODE_KANJI) {

            if ($pos + 1 < strlen($this->dataStr)) {
                $d = $this->dataStr[$pos + 1];
                $word = (ord($c) << 8) | ord($d);
                if (($word >= 0x8140 && $word <= 0x9ffc) || ($word >= 0xe040 && $word <= 0xebbf)) {
                    return QR_MODE_KANJI;
                }
            }
        }

        return QR_MODE_8;
    }

    /**
     * @return int
     */
    public function eatNum () : int
    {
        $ln = Specifications::lengthIndicator(QR_MODE_NUM, $this->input->getVersion());

        $p = 0;
        while (self::isDigitAt($this->dataStr, $p)) {
            $p++;
        }

        $run = $p;
        $mode = $this->identifyMode($p);

        if ($mode == QR_MODE_8) {
            $dif = Input::estimateBitsModeNum($run) + 4 + $ln
                + Input::estimateBitsMode8(1)         // + 4 + l8
                - Input::estimateBitsMode8($run + 1); // - 4 - l8
            if ($dif > 0) {
                return $this->eat8();
            }
        }
        if ($mode == QR_MODE_AN) {
            $dif = Input::estimateBitsModeNum($run) + 4 + $ln
                + Input::estimateBitsModeAn(1)        // + 4 + la
                - Input::estimateBitsModeAn($run + 1);// - 4 - la
            if ($dif > 0) {
                return $this->eatAn();
            }
        }

        $ret = $this->input->append(QR_MODE_NUM, $run, str_split($this->dataStr));
        if ($ret < 0)
            return -1;

        return $run;
    }

    /**
     * @return int
     */
    public function eatAn () : int
    {
        $la = Specifications::lengthIndicator(QR_MODE_AN, $this->input->getVersion());
        $ln = Specifications::lengthIndicator(QR_MODE_NUM, $this->input->getVersion());

        $p = 0;

        while (self::isAlnumAt($this->dataStr, $p)) {
            if (self::isDigitAt($this->dataStr, $p)) {
                $q = $p;
                while (self::isDigitAt($this->dataStr, $q)) {
                    $q++;
                }

                $dif = Input::estimateBitsModeAn($p) // + 4 + la
                    + Input::estimateBitsModeNum($q - $p) + 4 + $ln
                    - Input::estimateBitsModeAn($q); // - 4 - la

                if ($dif < 0) {
                    break;
                } else {
                    $p = $q;
                }
            } else {
                $p++;
            }
        }

        $run = $p;

        if (!self::isAlnumAt($this->dataStr, $p)) {
            $dif = Input::estimateBitsModeAn($run) + 4 + $la
                + Input::estimateBitsMode8(1) // + 4 + l8
                - Input::estimateBitsMode8($run + 1); // - 4 - l8
            if ($dif > 0) {
                return $this->eat8();
            }
        }

        $ret = $this->input->append(QR_MODE_AN, $run, str_split($this->dataStr));
        if ($ret < 0)
            return -1;

        return $run;
    }

    /**
     * @return int
     */
    public function eatKanji () : int
    {
        $p = 0;

        while ($this->identifyMode($p) == QR_MODE_KANJI) {
            $p += 2;
        }

        $ret = $this->input->append(QR_MODE_KANJI, $p, str_split($this->dataStr));
        if ($ret < 0)
            return -1;

        return $ret;
    }

    /**
     * @return int
     */
    public function eat8 () : int
    {
        $la = Specifications::lengthIndicator(QR_MODE_AN, $this->input->getVersion());
        $ln = Specifications::lengthIndicator(QR_MODE_NUM, $this->input->getVersion());

        $p = 1;
        $dataStrLen = strlen($this->dataStr);

        while ($p < $dataStrLen) {

            $mode = $this->identifyMode($p);
            if ($mode == QR_MODE_KANJI) {
                break;
            }
            if ($mode == QR_MODE_NUM) {
                $q = $p;
                while (self::isDigitAt($this->dataStr, $q)) {
                    $q++;
                }
                $dif = Input::estimateBitsMode8($p) // + 4 + l8
                    + Input::estimateBitsModeNum($q - $p) + 4 + $ln
                    - Input::estimateBitsMode8($q); // - 4 - l8
                if ($dif < 0) {
                    break;
                } else {
                    $p = $q;
                }
            } elseif ($mode == QR_MODE_AN) {
                $q = $p;
                while (self::isAlnumAt($this->dataStr, $q)) {
                    $q++;
                }
                $dif = Input::estimateBitsMode8($p)  // + 4 + l8
                    + Input::estimateBitsModeAn($q - $p) + 4 + $la
                    - Input::estimateBitsMode8($q); // - 4 - l8
                if ($dif < 0) {
                    break;
                } else {
                    $p = $q;
                }
            } else {
                $p++;
            }
        }

        $run = $p;
        $ret = $this->input->append(QR_MODE_8, $run, str_split($this->dataStr));

        if ($ret < 0)
            return -1;

        return $run;
    }

    /**
     * @return int
     */
    public function splitString () : int
    {
        while (strlen($this->dataStr) > 0) {
            if ($this->dataStr == '')
                return 0;

            $mode = $this->identifyMode(0);

            switch ($mode) {
                case QR_MODE_NUM:
                    $length = $this->eatNum();
                    break;
                case QR_MODE_AN:
                    $length = $this->eatAn();
                    break;
                case QR_MODE_KANJI:
                    if ($mode == QR_MODE_KANJI)
                        $length = $this->eatKanji();
                    else    $length = $this->eat8();
                    break;
                default:
                    $length = $this->eat8();
                    break;

            }

            if ($length == 0) return 0;
            if ($length < 0) return -1;

            $this->dataStr = substr($this->dataStr, $length);
        }

        return 1;
    }

    /**
     * @return string
     */
    public function toUpper () : string
    {
        $stringLen = strlen($this->dataStr);
        $p = 0;

        while ($p < $stringLen) {
            $mode = self::identifyMode(substr($this->dataStr, $p));
            if ($mode == QR_MODE_KANJI) {
                $p += 2;
            } else {
                if (ord($this->dataStr[$p]) >= ord('a') && ord($this->dataStr[$p]) <= ord('z')) {
                    $this->dataStr[$p] = chr(ord($this->dataStr[$p]) - 32);
                }
                $p++;
            }
        }

        return $this->dataStr;
    }

    /**
     * @param string                 $string
     * @param \QR_Code\Encoder\Input $input
     * @param int                    $modeHint
     * @param bool                   $caseSensitive
     * @return int
     * @throws \Exception
     */
    public static function splitStringToQRinput (string $string, Input $input, int $modeHint, bool $caseSensitive = true) : int
    {
        if (is_null($string) || $string == '\0' || $string == '') {
            throw new \Exception('empty string!!!');
        }

        $split = new self($string, $input, $modeHint);

        if (!$caseSensitive)
            $split->toUpper();

        return $split->splitString();
    }
}