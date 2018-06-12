<?php

namespace QR_Code\Util;

/**
 * Class Benchmark
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Util
 */
class Benchmark
{
    /**
     * Set mark
     *
     * @param string $id
     */
    public static function mark (string $id) : void
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = ((float) $usec + (float) $sec);

        if (!isset($GLOBALS['qr_time_bench']))
            $GLOBALS['qr_time_bench'] = [];

        $GLOBALS['qr_time_bench'][$id] = $time;
    }

    /**
     * Returns Benchmark table
     *
     * @return array
     */
    public static function getResults () : array
    {
        self::mark('finish');

        $lastTime = 0;
        $startTime = 0;
        $p = 0;

        $returnArr = [];

        foreach ($GLOBALS['qr_time_bench'] as $id => $thisTime) {
            if ($p > 0) {
                $returnArr["Seconds until {$id}"] = number_format($thisTime - $lastTime, 6);
            } else {
                $startTime = $thisTime;
            }
            $p++;
            $lastTime = $thisTime;
        }
        $returnArr['Total'] = number_format($lastTime - $startTime, 6);

        return $returnArr;
    }
}