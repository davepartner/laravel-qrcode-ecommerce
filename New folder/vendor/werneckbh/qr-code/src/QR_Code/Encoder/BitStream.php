<?php

namespace QR_Code\Encoder;

/**
 * QR Code BitStream
 *
 * Based on libqrencode C library distributed under LGPL 2.1
 * Copyright (C) 2006, 2007, 2008, 2009 Kentaro Fukuchi <fukuchi@megaui.net>
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Encoder
 */
class BitStream
{
    public $data = [];

    /**
     * @return int
     */
    public function size () : int
    {
        return count($this->data);
    }

    /**
     * @param $setLength
     * @return int
     */
    public function allocate ($setLength) : int
    {
        $this->data = array_fill(0, $setLength, 0);

        return 0;
    }

    /**
     * @param $bits
     * @param $num
     * @return \QR_Code\Encoder\BitStream
     */
    public static function newFromNum ($bits, $num) : BitStream
    {
        $bitStream = new self();
        $bitStream->allocate($bits);

        $mask = 1 << ($bits - 1);
        for ($i = 0; $i < $bits; $i++) {
            if ($num & $mask) {
                $bitStream->data[$i] = 1;
            } else {
                $bitStream->data[$i] = 0;
            }
            $mask = $mask >> 1;
        }

        return $bitStream;
    }

    /**
     * @param $size
     * @param $data
     * @return \QR_Code\Encoder\BitStream
     */
    public static function newFromBytes ($size, $data) : BitStream
    {
        $bitStream = new self();
        $bitStream->allocate($size * 8);
        $p = 0;

        for ($i = 0; $i < $size; $i++) {
            $mask = 0x80;
            for ($j = 0; $j < 8; $j++) {
                if ($data[$i] & $mask) {
                    $bitStream->data[$p] = 1;
                } else {
                    $bitStream->data[$p] = 0;
                }
                $p++;
                $mask = $mask >> 1;
            }
        }

        return $bitStream;
    }

    /**
     * @param \QR_Code\Encoder\BitStream $arg
     * @return int
     */
    public function append (self $arg) : int
    {
        if (is_null($arg)) {
            return -1;
        }

        if ($arg->size() == 0) {
            return 0;
        }

        if ($this->size() == 0) {
            $this->data = $arg->data;
            return 0;
        }

        $this->data = array_values(array_merge($this->data, $arg->data));

        return 0;
    }

    /**
     * @param $bits
     * @param $num
     * @return int
     */
    public function appendNum ($bits, $num) : int
    {
        if ($bits == 0)
            return 0;

        $b = self::newFromNum($bits, $num);

        if (is_null($b))
            return -1;

        $ret = $this->append($b);
        unset($b);

        return $ret;
    }

    /**
     * @param $size
     * @param $data
     * @return int
     */
    public function appendBytes ($size, $data) : int
    {
        if ($size == 0)
            return 0;

        $b = self::newFromBytes($size, $data);

        if (is_null($b))
            return -1;

        $ret = $this->append($b);
        unset($b);

        return $ret;
    }

    /**
     * @return array
     */
    public function toByte () : array
    {
        $size = $this->size();

        if ($size == 0) {
            return [];
        }

        $data = array_fill(0, (int) (($size + 7) / 8), 0);
        $bytes = (int) ($size / 8);

        $p = 0;

        for ($i = 0; $i < $bytes; $i++) {
            $v = 0;
            for ($j = 0; $j < 8; $j++) {
                $v = $v << 1;
                $v |= $this->data[$p];
                $p++;
            }
            $data[$i] = $v;
        }

        if ($size & 7) {
            $v = 0;
            for ($j = 0; $j < ($size & 7); $j++) {
                $v = $v << 1;
                $v |= $this->data[$p];
                $p++;
            }
            $data[$bytes] = $v;
        }

        return $data;
    }
}