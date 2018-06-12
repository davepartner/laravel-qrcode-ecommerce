<?php

namespace QR_Code\Util;

/**
 * Class Logger
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Util
 */
class Logger
{
    /**
     * Log Errors
     *
     * @param string|bool $outfile
     * @param string      $err
     */
    public static function log ($outfile, string $err) : void
    {
        if (QR_LOG_DIR !== false) {
            if ($err != '') {
                $data = date('Y-m-d H:i:s') . ': ' . $err . PHP_EOL;
                if ($outfile !== false) {
                    file_put_contents(QR_LOG_DIR . basename($outfile) . '-errors.txt', $data, FILE_APPEND);
                } else {
                    file_put_contents(QR_LOG_DIR . 'errors.txt', $data, FILE_APPEND);
                }
            }
        }
    }
}