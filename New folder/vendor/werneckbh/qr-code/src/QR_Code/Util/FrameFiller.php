<?php

namespace QR_Code\Util;

/**
 * Class FrameFiller
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Util
 */
class FrameFiller
{
    public $width;
    public $frame;
    public $x;
    public $y;
    public $dir;
    public $bit;

    /**
     * FrameFiller constructor.
     * @param int   $width
     * @param array $frame
     */
    public function __construct (int $width, array &$frame)
    {
        $this->width = $width;
        $this->frame = $frame;
        $this->x = $width - 1;
        $this->y = $width - 1;
        $this->dir = -1;
        $this->bit = -1;
    }

    /**
     * @param $at
     * @param $val
     */
    public function setFrameAt ($at, $val) : void
    {
        $this->frame[$at['y']][$at['x']] = chr($val);
    }

    /**
     * @param $at
     * @return int
     */
    public function getFrameAt ($at) : int
    {
        return ord($this->frame[$at['y']][$at['x']]);
    }

    /**
     * @return array|null
     */
    public function next ()
    {
        do {

            if ($this->bit == -1) {
                $this->bit = 0;
                return ['x' => $this->x, 'y' => $this->y];
            }

            $x = $this->x;
            $y = $this->y;
            $w = $this->width;

            if ($this->bit == 0) {
                $x--;
                $this->bit++;
            } else {
                $x++;
                $y += $this->dir;
                $this->bit--;
            }

            if ($this->dir < 0) {
                if ($y < 0) {
                    $y = 0;
                    $x -= 2;
                    $this->dir = 1;
                    if ($x == 6) {
                        $x--;
                        $y = 9;
                    }
                }
            } else {
                if ($y == $w) {
                    $y = $w - 1;
                    $x -= 2;
                    $this->dir = -1;
                    if ($x == 6) {
                        $x--;
                        $y -= 8;
                    }
                }
            }
            if ($x < 0 || $y < 0) return null;

            $this->x = $x;
            $this->y = $y;

        } while (ord($this->frame[$y][$x]) & 0x80);

        return ['x' => $x, 'y' => $y];
    }
}