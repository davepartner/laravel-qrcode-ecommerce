<?php

namespace QR_Code\Encoder;

use QR_Code\Config\Specifications;

/**
 * Class Input
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Encoder
 */
class Input
{
    public $items;

    private $version;
    private $level;

    /**
     * Input constructor.
     * @param int        $version
     * @param int|string $level
     * @throws \Exception
     */
    public function __construct (int $version = 0, $level = QR_ECLEVEL_L)
    {
        if ($version < 0 || $version > QRSPEC_VERSION_MAX || $level > QR_ECLEVEL_H) {
            throw new \Exception('Invalid version no');
        }

        $this->version = $version;
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getVersion () : int
    {
        return $this->version;
    }

    /**
     * @param int $version
     * @return int
     * @throws \Exception
     */
    public function setVersion (int $version) : int
    {
        if ($version < 0 || $version > QRSPEC_VERSION_MAX) {
            throw new \Exception('Invalid version no');
        }

        $this->version = $version;

        return 0;
    }

    /**
     * @return int
     */
    public function getErrorCorrectionLevel () : int
    {
        return $this->level;
    }

    /**
     * @param $level
     * @return int
     * @throws \Exception
     */
    public function setErrorCorrectionLevel ($level) : int
    {
        if ($level > QR_ECLEVEL_H) {
            throw new \Exception('Invalid ECLEVEL');
        }

        $this->level = $level;

        return 0;
    }

    /**
     * @param \QR_Code\Encoder\InputItem $entry
     */
    public function appendEntry (InputItem $entry) : void
    {
        $this->items[] = $entry;
    }

    /**
     * @param $mode
     * @param $size
     * @param $data
     * @return int
     */
    public function append ($mode, $size, $data) : int
    {
        try {
            $entry = new InputItem($mode, $size, $data);
            $this->items[] = $entry;
            return 0;
        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @param int   $size
     * @param int   $index
     * @param array $parity
     * @return int
     * @throws \Exception
     */
    public function insertStructuredAppendHeader (int $size, int $index, array $parity) : int
    {
        if ($size > MAX_STRUCTURED_SYMBOLS) {
            throw new \Exception('insertStructuredAppendHeader wrong size');
        }

        if ($index <= 0 || $index > MAX_STRUCTURED_SYMBOLS) {
            throw new \Exception('insertStructuredAppendHeader wrong index');
        }

        $buf = [$size, $index, $parity];

        try {
            $entry = new InputItem(QR_MODE_STRUCTURE, 3, $buf);
            array_unshift($this->items, $entry);
            return 0;
        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @return int
     */
    public function calcParity () : int
    {
        $parity = 0;

        foreach ($this->items as $item) {
            if ($item->mode != QR_MODE_STRUCTURE) {
                for ($i = $item->size - 1; $i >= 0; $i--) {
                    $parity ^= $item->data[$i];
                }
            }
        }

        return $parity;
    }

    /**
     * @param int   $size
     * @param mixed $data
     * @return bool
     */
    public static function checkModeNum (int $size, $data) : bool
    {
        for ($i = 0; $i < $size; $i++) {
            if ((ord($data[$i]) < ord('0')) || (ord($data[$i]) > ord('9'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $size
     * @return float|int
     */
    public static function estimateBitsModeNum (int $size)
    {
        $w = (int) $size / 3;
        $bits = $w * 10;

        switch ($size - $w * 3) {
            case 1:
                $bits += 4;
                break;
            case 2:
                $bits += 7;
                break;
            default:
                break;
        }

        return $bits;
    }

    /**
     * @var array
     */
    public static $anTable = [
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        36, -1, -1, -1, 37, 38, -1, -1, -1, -1, 39, 40, -1, 41, 42, 43,
        0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 44, -1, -1, -1, -1, -1,
        -1, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
        25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
    ];

    /**
     * @param int $c
     * @return int|mixed
     */
    public static function lookAnTable (int $c)
    {
        return (($c > 127) ? -1 : self::$anTable[$c]);
    }

    /**
     * @param int   $size
     * @param mixed $data
     * @return bool
     */
    public static function checkModeAn (int $size, $data) : bool
    {
        for ($i = 0; $i < $size; $i++) {
            if (self::lookAnTable(ord($data[$i])) == -1) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $size
     * @return float|int
     */
    public static function estimateBitsModeAn (int $size)
    {
        $w = (int) ($size / 2);
        $bits = $w * 11;

        if ($size & 1) {
            $bits += 6;
        }

        return $bits;
    }

    /**
     * @param int $size
     * @return float|int
     */
    public static function estimateBitsMode8 (int $size)
    {
        return $size * 8;
    }

    /**
     * @param int $size
     * @return int
     */
    public static function estimateBitsModeKanji (int $size) : int
    {
        return (int) (($size / 2) * 13);
    }

    /**
     * @param int   $size
     * @param mixed $data
     * @return bool
     */
    public static function checkModeKanji (int $size, $data) : bool
    {
        if ($size & 1)
            return false;

        for ($i = 0; $i < $size; $i += 2) {
            $val = (ord($data[$i]) << 8) | ord($data[$i + 1]);
            if ($val < 0x8140
                || ($val > 0x9ffc && $val < 0xe040)
                || $val > 0xebbf) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validation
     *
     * @param int   $mode
     * @param int   $size
     * @param mixed $data
     * @return bool
     */
    public static function check (int $mode, int $size, $data) : bool
    {
        if ($size <= 0)
            return false;

        switch ($mode) {
            case QR_MODE_NUM:
                return self::checkModeNum($size, $data);
                break;
            case QR_MODE_AN:
                return self::checkModeAn($size, $data);
                break;
            case QR_MODE_KANJI:
                return self::checkModeKanji($size, $data);
                break;
            case QR_MODE_8:
                return true;
                break;
            case QR_MODE_STRUCTURE:
                return true;
                break;

            default:
                break;
        }

        return false;
    }


    /**
     * @param int $version
     * @return float|int
     */
    public function estimateBitStreamSize (int $version)
    {
        $bits = 0;

        /**
         * @var $item \QR_Code\Encoder\InputItem
         */
        foreach ($this->items as $item) {
            $bits += $item->estimateBitStreamSizeOfEntry($version);
        }

        return $bits;
    }

    /**
     * @return int
     */
    public function estimateVersion () : int
    {
        $version = 0;

        do {
            $prev = $version;
            $bits = $this->estimateBitStreamSize($prev);
            $version = Specifications::getMinimumVersion((int) (($bits + 7) / 8), $this->level);
            if ($version < 0) {
                return -1;
            }
        } while ($version > $prev);

        return $version;
    }

    /**
     * @param int $mode
     * @param int $version
     * @param     $bits
     * @return float|int
     */
    public static function lengthOfCode (int $mode, int $version, $bits)
    {
        $payload = $bits - 4 - Specifications::lengthIndicator($mode, $version);
        switch ($mode) {
            case QR_MODE_NUM:
                $chunks = (int) ($payload / 10);
                $remain = $payload - $chunks * 10;
                $size = $chunks * 3;
                if ($remain >= 7) {
                    $size += 2;
                } elseif ($remain >= 4) {
                    $size += 1;
                }
                break;
            case QR_MODE_AN:
                $chunks = (int) ($payload / 11);
                $remain = $payload - $chunks * 11;
                $size = $chunks * 2;
                if ($remain >= 6)
                    $size++;
                break;
            case QR_MODE_8:
                $size = (int) ($payload / 8);
                break;
            case QR_MODE_KANJI:
                $size = (int) (($payload / 13) * 2);
                break;
            case QR_MODE_STRUCTURE:
                $size = (int) ($payload / 8);
                break;
            default:
                $size = 0;
                break;
        }

        $maxsize = Specifications::maximumWords($mode, $version);
        if ($size < 0) $size = 0;
        if ($size > $maxsize) $size = $maxsize;

        return $size;
    }

    /**
     * @return int
     */
    public function createBitStream () : int
    {
        $total = 0;

        /**
         * @var $item \QR_Code\Encoder\InputItem
         */
        foreach ($this->items as $item) {
            $bits = $item->encodeBitStream($this->version);

            if ($bits < 0)
                return -1;

            $total += $bits;
        }

        return $total;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function convertData () : int
    {
        $ver = $this->estimateVersion();
        if ($ver > $this->getVersion()) {
            $this->setVersion($ver);
        }

        for (; ;) {
            $bits = $this->createBitStream();

            if ($bits < 0)
                return -1;

            $ver = Specifications::getMinimumVersion((int) (($bits + 7) / 8), $this->level);
            if ($ver < 0) {
                throw new \Exception('WRONG VERSION');
            } elseif ($ver > $this->getVersion()) {
                $this->setVersion($ver);
            } else {
                break;
            }
        }

        return 0;
    }

    /**
     * @param \QR_Code\Encoder\BitStream $bitStream
     * @return int
     */
    public function appendPaddingBit (BitStream &$bitStream) : int
    {
        $bits = $bitStream->size();
        $maxwords = Specifications::getDataLength($this->version, $this->level);
        $maxbits = $maxwords * 8;

        if ($maxbits == $bits) {
            return 0;
        }

        if ($maxbits - $bits < 5) {
            return $bitStream->appendNum($maxbits - $bits, 0);
        }

        $bits += 4;
        $words = (int) (($bits + 7) / 8);

        $padding = new BitStream();
        $ret = $padding->appendNum($words * 8 - $bits + 4, 0);

        if ($ret < 0)
            return $ret;

        $padlen = $maxwords - $words;

        if ($padlen > 0) {

            $padbuf = [];
            for ($i = 0; $i < $padlen; $i++) {
                $padbuf[$i] = ($i & 1) ? 0x11 : 0xec;
            }

            $ret = $padding->appendBytes($padlen, $padbuf);

            if ($ret < 0)
                return $ret;

        }

        $ret = $bitStream->append($padding);

        return $ret;
    }

    /**
     * @return null|\QR_Code\Encoder\BitStream
     * @throws \Exception
     */
    public function mergeBitStream ()
    {
        if ($this->convertData() < 0) {
            return null;
        }

        $bitStream = new BitStream();

        foreach ($this->items as $item) {
            $ret = $bitStream->append($item->bitStream);
            if ($ret < 0) {
                return null;
            }
        }

        return $bitStream;
    }

    /**
     * @return null|\QR_Code\Encoder\BitStream
     * @throws \Exception
     */
    public function getBitStream ()
    {

        $bitStream = $this->mergeBitStream();

        if ($bitStream == null) {
            return null;
        }

        $ret = $this->appendPaddingBit($bitStream);
        if ($ret < 0) {
            return null;
        }

        return $bitStream;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getByteStream () : array
    {
        $bitStream = $this->getBitStream();
        if ($bitStream == null) {
            return [];
        }

        return $bitStream->toByte();
    }
}