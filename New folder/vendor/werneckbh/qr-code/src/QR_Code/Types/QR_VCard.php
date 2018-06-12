<?php

namespace QR_Code\Types;

use QR_Code\Contracts\CodeType;
use QR_Code\Exceptions\InvalidVCardAddressEntryException;
use QR_Code\Exceptions\InvalidVCardPhoneEntryException;
use QR_Code\Types\vCard\Address;
use QR_Code\Types\vCard\Person;
use QR_Code\Types\vCard\Phone;
use QR_Code\Util\AbstractGenerator;

/**
 * Class QR_VCard
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types
 */
class QR_VCard extends AbstractGenerator implements CodeType
{
    /**
     * @var \QR_Code\Types\vCard\Person
     */
    protected $person;
    /**
     * @var \QR_Code\Types\vCard\Phone[]
     */
    protected $phones;
    /**
     * @var \QR_Code\Types\vCard\Address[]
     */
    protected $addresses;
    /**
     * @var string
     */
    private $rev;

    /**
     * QR_VCard constructor.
     * @param \QR_Code\Types\vCard\Person    $person
     * @param \QR_Code\Types\vCard\Phone[]   $phones
     * @param \QR_Code\Types\vCard\Address[] $addresses
     */
    public function __construct (Person $person, array $phones = [], array $addresses = [])
    {
        $this->validateAddresses($addresses);
        $this->validatePhones($phones);

        $this->person = $person;
        $this->phones = $phones;
        $this->addresses = $addresses;
        $this->rev = "REV:" . (new \DateTime('NOW'))->format('Y:m:d\TH:i:s\Z') . "\n";
    }

    /**
     * @param \QR_Code\Types\vCard\Phone[] $phones
     * @throws \QR_Code\Exceptions\InvalidVCardPhoneEntryException
     */
    protected function validatePhones (array $phones) : void
    {
        foreach ($phones as $phone) {
            if (!$phone instanceof Phone) {
                throw new InvalidVCardPhoneEntryException('Invalid VCard Phone Entry');
            }
        }
    }

    /**
     * @param \QR_Code\Types\vCard\Address[] $addresses
     * @throws \QR_Code\Exceptions\InvalidVCardAddressEntryException
     */
    protected function validateAddresses (array $addresses) : void
    {
        foreach ($addresses as $address) {
            if (!$address instanceof Address) {
                throw new InvalidVCardAddressEntryException('Invalid VCard Address Entry');
            }
        }
    }

    /**
     * Get Formatted QR Code String
     *
     * @return string
     */
    public function getCodeString () : string
    {
        $response = "BEGIN:VCARD\nVERSION:3.0\n";
        $response .= (string) $this->person;

        foreach ($this->phones as $phone) {
            $response .= (string) $phone;
        }

        foreach ($this->addresses as $address) {
            $response .= (string) $address;
        }

        $response .= "{$this->person->getEmailStr()}";

        $response .= $this->rev;

        $response .= "END:VCARD";

        return $response;
    }
}