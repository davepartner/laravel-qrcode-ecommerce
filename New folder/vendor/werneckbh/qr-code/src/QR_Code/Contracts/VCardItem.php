<?php
namespace QR_Code\Contracts;

/**
 * Interface VCardItem
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Contracts
 */
interface VCardItem
{
    /**
     * Gets vCard Item Text
     *
     * @return string
     */
    public function __toString () : string;
}