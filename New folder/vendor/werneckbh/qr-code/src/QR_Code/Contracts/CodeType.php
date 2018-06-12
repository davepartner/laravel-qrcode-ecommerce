<?php

namespace QR_Code\Contracts;

/**
 * Interface CodeType
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Contracts
 */
interface CodeType
{
    /**
     * Get Formatted QR Code String
     *
     * @return string Code String
     */
    public function getCodeString () : string;
}