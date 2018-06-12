<?php

namespace QR_Code\Types;

use QR_Code\Contracts\CodeType;
use QR_Code\Util\AbstractGenerator;

/**
 * Class QR_WiFi
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types
 */
class QR_WiFi extends AbstractGenerator implements CodeType
{
    protected $authentication;
    protected $ssid;
    protected $password;
    protected $hidden;

    /**
     * QR_WiFi constructor.
     * @param string $authentication Authentication type (WPA, WPA2, WEP)
     * @param string $ssid
     * @param string $password
     * @param bool   $hidden
     */
    public function __construct(string $authentication, string $ssid, string $password, bool $hidden = false)
    {
        $this->authentication = $authentication;
        $this->ssid = $ssid;
        $this->password = $password;
        $this->hidden = $hidden;
    }

    /**
     * Get Formatted QR Code String
     *
     * @return string
     */
    public function getCodeString () : string
    {
        $response = "WIFI:T:{$this->authentication};S:{$this->ssid};P:{$this->password};";
        if ($this->hidden) {
            $response .= "H:true;";
        } else {
            $response .= ";";
        }

        return $response;
    }
}