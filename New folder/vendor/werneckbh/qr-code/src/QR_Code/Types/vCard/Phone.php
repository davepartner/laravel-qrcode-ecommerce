<?php

namespace QR_Code\Types\vCard;

use QR_Code\Contracts\VCardItem;

/**
 * Class Phone
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types\vCard
 */
class Phone implements VCardItem
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $number;
    /**
     * @var bool
     */
    protected $cellphone;

    /**
     * Phone constructor.
     * @param string $type WORK|HOME
     * @param string $number
     * @param bool   $cellphone
     */
    public function __construct (string $type, string $number, bool $cellphone = false)
    {
        $this->type = $type;
        $this->number = $number;
        $this->cellphone = $cellphone;
    }

    /**
     * Gets vCard Item Text
     *
     * @return string
     */
    public function __toString () : string
    {
        $response = "TEL;TYPE={$this->type},";
        $response .= $this->cellphone ? "CELL:" : "VOICE:";
        $response .= $this->number . "\n";

        return $response;
    }
}