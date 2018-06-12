<?php

namespace QR_Code\Encoder;

use QR_Code\Config\Specifications;

/**
 * Class InputItem
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Encoder
 */
class InputItem
{
    public $mode;
    public $size;
    public $data;
    /**
     * @var \QR_Code\Encoder\BitStream
     */
    public $bitStream;

    /**
     * InputItem constructor.
     * @param int                        $mode
     * @param int                        $size
     * @param mixed                      $data
     * @param \QR_Code\Encoder\BitStream $bitStream
     * @throws \Exception
     */
    public function __construct (int $mode, int $size, $data, BitStream $bitStream = null)
    {
        $setData = array_slice($data, 0, $size);

        if (count($setData) < $size) {
            $setData = array_merge($setData, array_fill(0, $size - count($setData), 0));
        }

        if (!Input::check($mode, $size, $setData)) {
            throw new \Exception('Error m:' . $mode . ',s:' . $size . ',d:' . join(',', $setData));
        }

        $this->mode = $mode;
        $this->size = $size;
        $this->data = $setData;
        $this->bitStream = $bitStream;
    }

    /**
     * @param int $version
     * @return int
     */
    public function encodeModeNum (int $version) : int
    {
        try {

            $words = (int) ($this->size / 3);
            $bs = new BitStream();

            $val = 0x1;
            $bs->appendNum(4, $val);
            $bs->appendNum(Specifications::lengthIndicator(QR_MODE_NUM, $version), $this->size);

            for ($i = 0; $i < $words; $i++) {
                $val = (ord($this->data[$i * 3]) - ord('0')) * 100;
                $val += (ord($this->data[$i * 3 + 1]) - ord('0')) * 10;
                $val += (ord($this->data[$i * 3 + 2]) - ord('0'));
                $bs->appendNum(10, $val);
            }

            if ($this->size - $words * 3 == 1) {
                $val = ord($this->data[$words * 3]) - ord('0');
                $bs->appendNum(4, $val);
            } elseif ($this->size - $words * 3 == 2) {
                $val = (ord($this->data[$words * 3]) - ord('0')) * 10;
                $val += (ord($this->data[$words * 3 + 1]) - ord('0'));
                $bs->appendNum(7, $val);
            }

            $this->bitStream = $bs;
            return 0;

        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @param int $version
     * @return int
     */
    public function encodeModeAn (int $version) : int
    {
        try {
            $words = (int) ($this->size / 2);
            $bs = new BitStream();

            $bs->appendNum(4, 0x02);
            $bs->appendNum(Specifications::lengthIndicator(QR_MODE_AN, $version), $this->size);

            for ($i = 0; $i < $words; $i++) {
                $val = (int) Input::lookAnTable(ord($this->data[$i * 2])) * 45;
                $val += (int) Input::lookAnTable(ord($this->data[$i * 2 + 1]));

                $bs->appendNum(11, $val);
            }

            if ($this->size & 1) {
                $val = Input::lookAnTable(ord($this->data[$words * 2]));
                $bs->appendNum(6, $val);
            }

            $this->bitStream = $bs;
            return 0;

        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @param int $version
     * @return int
     */
    public function encodeMode8 (int $version) : int
    {
        try {
            $bs = new BitStream();

            $bs->appendNum(4, 0x4);
            $bs->appendNum(Specifications::lengthIndicator(QR_MODE_8, $version), $this->size);

            for ($i = 0; $i < $this->size; $i++) {
                $bs->appendNum(8, ord($this->data[$i]));
            }

            $this->bitStream = $bs;
            return 0;

        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @param int $version
     * @return int
     */
    public function encodeModeKanji (int $version) : int
    {
        try {

            $bs = new BitStream();

            $bs->appendNum(4, 0x8);
            $bs->appendNum(Specifications::lengthIndicator(QR_MODE_KANJI, $version), (int) ($this->size / 2));

            for ($i = 0; $i < $this->size; $i += 2) {
                $val = (ord($this->data[$i]) << 8) | ord($this->data[$i + 1]);
                if ($val <= 0x9ffc) {
                    $val -= 0x8140;
                } else {
                    $val -= 0xc140;
                }

                $h = ($val >> 8) * 0xc0;
                $val = ($val & 0xff) + $h;

                $bs->appendNum(13, $val);
            }

            $this->bitStream = $bs;
            return 0;

        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @return int
     */
    public function encodeModeStructure () : int
    {
        try {
            $bs = new BitStream();

            $bs->appendNum(4, 0x03);
            $bs->appendNum(4, ord($this->data[1]) - 1);
            $bs->appendNum(4, ord($this->data[0]) - 1);
            $bs->appendNum(8, ord($this->data[2]));

            $this->bitStream = $bs;
            return 0;

        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * @param int $version
     * @return float|int
     */
    public function estimateBitStreamSizeOfEntry (int $version)
    {
        if ($version == 0)
            $version = 1;

        switch ($this->mode) {
            case QR_MODE_NUM:
                $bits = Input::estimateBitsModeNum($this->size);
                break;
            case QR_MODE_AN:
                $bits = Input::estimateBitsModeAn($this->size);
                break;
            case QR_MODE_8:
                $bits = Input::estimateBitsMode8($this->size);
                break;
            case QR_MODE_KANJI:
                $bits = Input::estimateBitsModeKanji($this->size);
                break;
            case QR_MODE_STRUCTURE:
                return STRUCTURE_HEADER_BITS;
            default:
                return 0;
        }

        $l = Specifications::lengthIndicator($this->mode, $version);
        $m = 1 << $l;
        $num = (int) (($this->size + $m - 1) / $m);

        $bits += $num * (4 + $l);

        return $bits;
    }

    /**
     * @param int $version
     * @return int
     */
    public function encodeBitStream (int $version) : int
    {
        try {
            unset($this->bitStream);
            $words = Specifications::maximumWords($this->mode, $version);

            if ($this->size > $words) {

                $st1 = new self($this->mode, $words, $this->data);
                $st2 = new self($this->mode, $this->size - $words, array_slice($this->data, $words));

                $st1->encodeBitStream($version);
                $st2->encodeBitStream($version);

                $this->bitStream = new BitStream();
                $this->bitStream->append($st1->bitStream);
                $this->bitStream->append($st2->bitStream);

                unset($st1);
                unset($st2);

            } else {

                $ret = 0;

                switch ($this->mode) {
                    case QR_MODE_NUM:
                        $ret = $this->encodeModeNum($version);
                        break;
                    case QR_MODE_AN:
                        $ret = $this->encodeModeAn($version);
                        break;
                    case QR_MODE_8:
                        $ret = $this->encodeMode8($version);
                        break;
                    case QR_MODE_KANJI:
                        $ret = $this->encodeModeKanji($version);
                        break;
                    case QR_MODE_STRUCTURE:
                        $ret = $this->encodeModeStructure();
                        break;

                    default:
                        break;
                }

                if ($ret < 0)
                    return -1;
            }

            return $this->bitStream->size();

        } catch (\Exception $e) {
            return -1;
        }
    }
}