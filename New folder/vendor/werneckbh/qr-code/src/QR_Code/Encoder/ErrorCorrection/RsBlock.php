<?php

namespace QR_Code\Encoder\ErrorCorrection;

/**
 * Class RsBlock
 *
 * Reed-Solomon error correction support
 *
 * Copyright (C) 2002, 2003, 2004, 2006 Phil Karn, KA9Q
 * (libfec is released under the GNU Lesser General Public License.)
 *
 * Based on libqrencode C library distributed under LGPL 2.1
 * Copyright (C) 2006, 2007, 2008, 2009 Kentaro Fukuchi <fukuchi@megaui.net>
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Encoder\ErrorCorrection
 */
class RsBlock
{
    protected $dataLength;
    protected $data = [];
    protected $eccLength;
    protected $ecc  = [];

    /**
     * RsBlock constructor.
     * @param                                         $dl
     * @param                                         $data
     * @param                                         $el
     * @param array                                   $ecc
     * @param \QR_Code\Encoder\ErrorCorrection\RsItem $rs
     */
    public function __construct ($dl, $data, $el, array &$ecc, RsItem $rs)
    {
        $rs->encode_rs_char($data, $ecc);

        $this->dataLength = $dl;
        $this->data = $data;
        $this->eccLength = $el;
        $this->ecc = $ecc;
    }

    /**
     * @param string $property
     * @return mixed|null
     */
    public function __get (string $property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }
}