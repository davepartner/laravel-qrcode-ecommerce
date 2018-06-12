<?php

namespace QR_Code\Util;

use QR_Code\Config\Specifications;
use QR_Code\Encoder\Image;
use QR_Code\Encoder\Mask;

/**
 * Class Tools
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Util
 */
class Tools
{
    /**
     * @var array
     */
    protected static $frames = [];

    /**
     * Transform frame in binary
     *
     * @param array $frame
     * @return array
     */
    public static function binarize (array $frame) : array
    {
        $len = count($frame);

        foreach ($frame as &$frameLine) {
            for ($i = 0; $i < $len; $i++) {
                $frameLine[$i] = (ord($frameLine[$i]) & 1) ? '1' : '0';
            }
        }

        return $frame;
    }

    /**
     * Reset internal frames property
     */
    public static function clearCache () : void
    {
        self::$frames = [];
    }

    /**
     * Clear Temporary QR Code Files in TEMP_DIR directory
     *
     * @return void
     */
    public static function clearTemporaryQRCodes () : void
    {
        dropFilesBySubstring(TEMP_DIR, 'qr_code_');
    }

    /**
     * Dump current mask contents
     *
     * @param array $frame
     */
    public static function dumpMask (array $frame) : void
    {
        $width = count($frame);
        for ($y = 0; $y < $width; $y++) {
            for ($x = 0; $x < $width; $x++) {
                echo ord($frame[$y][$x]) . ',';
            }
        }
    }

    /**
     * Build application cache
     */
    public static function buildCache () : void
    {
        Benchmark::mark('build_cache_start');

        $mask = new Mask();
        for ($a = 1; $a <= QRSPEC_VERSION_MAX; $a++) {
            $frame = Specifications::newFrame($a);
            if (QR_IMAGE) {
                $fileName = QR_CACHE_DIR . 'frame_' . $a . '.png';
                Image::png(self::binarize($frame), $fileName, 1, 0);
            }

            $width = count($frame);
            $bitMask = array_fill(0, $width, array_fill(0, $width, 0));
            for ($maskNo = 0; $maskNo < 8; $maskNo++)
                $mask->makeMaskNo($maskNo, $width, $frame, $bitMask, true);
        }

        Benchmark::mark('build_cache_end');
    }

    /**
     * Save file
     *
     * @param        $content
     * @param string $filename_path
     * @return bool
     */
    public static function save ($content, string $filename_path) : bool
    {
        try {
            $handle = fopen($filename_path, "w");
            fwrite($handle, $content);
            fclose($handle);
            return true;
        } catch (\Exception $e) {
            echo 'Exception writing file : ', $e->getMessage(), "\n";
        }

        return false;
    }
}