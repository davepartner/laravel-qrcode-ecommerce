<?php

namespace QR_Code\Types;

use QR_Code\Contracts\CodeType;
use QR_Code\Util\AbstractGenerator;

/**
 * Class QR_Phone
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types
 */
class QR_Phone extends AbstractGenerator implements CodeType
{
    protected $phone;

    /**
     * Phone QR Code
     *
     * @param $phone
     */
    public function __construct (string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get Formatted QR Code String
     *
     * @return string
     */
    public function getCodeString () : string
    {
        return "TEL:{$this->phone}";
    }
}