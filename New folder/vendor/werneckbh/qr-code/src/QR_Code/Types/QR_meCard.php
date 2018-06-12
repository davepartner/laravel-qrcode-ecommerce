<?php

namespace QR_Code\Types;

use QR_Code\Contracts\CodeType;
use QR_Code\Util\AbstractGenerator;

/**
 * Class QR_meCard
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types
 */
class QR_meCard extends AbstractGenerator implements CodeType
{
    protected $name;
    protected $address;
    protected $phone;
    protected $email;

    /**
     * MeCard QR Code
     *
     * @param string $name
     * @param string $address
     * @param string $phone
     * @param string $email
     */
    public function __construct (string $name, string $address, string $phone, string $email)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
    }

    /**
     * Get Formatted QR Code String
     *
     * @return string
     */
    public function getCodeString () : string
    {
        return "MECARD:N:{$this->name};ADR:{$this->address};TEL:{$this->phone};EMAIL:{$this->email};;";
    }
}