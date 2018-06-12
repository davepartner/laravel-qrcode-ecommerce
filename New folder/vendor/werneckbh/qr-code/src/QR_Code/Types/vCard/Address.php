<?php

namespace QR_Code\Types\vCard;

use QR_Code\Contracts\VCardItem;

/**
 * Class Address
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types\vCard
 */
class Address implements VCardItem
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var bool
     */
    protected $pref;
    /**
     * @var string
     */
    protected $street;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $state;
    /**
     * @var string
     */
    protected $zip;
    /**
     * @var string
     */
    protected $country;

    /**
     * Address constructor.
     * @param string $type HOME|WORK
     * @param bool   $pref Is PREF address
     * @param string $street
     * @param string $city
     * @param string $state
     * @param string $zip
     * @param string $country
     */
    public function __construct (string $type, bool $pref = true, string $street, string $city, string $state, string $zip, string $country)
    {
        $this->type = $type;
        $this->pref = $pref;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->country = $country;
    }

    /**
     * Gets vCard Item Text
     *
     * @return string
     */
    public function __toString () : string
    {
        $response = "ADR;TYPE={$this->type}";
        $response .= $this->pref ? ",PREF:;;" : ":;;";
        $response .= "{$this->street};{$this->city};{$this->state};{$this->zip};{$this->country}\n";

        $response .= "LABEL;TYPE={$this->type}";
        $response .= $this->pref ? ",PREF:" : ":";
        $response .= "{$this->street}\\n{$this->city}\, {$this->city} {$this->zip}\\n{$this->country}\n";

        return $response;
    }
}