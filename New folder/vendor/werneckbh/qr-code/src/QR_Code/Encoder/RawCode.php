<?php

namespace QR_Code\Encoder;

use QR_Code\Config\Specifications;
use QR_Code\Encoder\ErrorCorrection\Rs;
use QR_Code\Encoder\ErrorCorrection\RsBlock;

/**
 * Class RawCode
 *
 * Based on PHP QR Code distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Encoder
 */
class RawCode
{
    public $version;
    public $dataCode = [];
    public $eccCode  = [];
    public $blocks;
    public $rsBlocks = []; //of rsBlocs
    public $count;
    public $dataLength;
    public $eccLength;
    public $b1;

    /**
     * RawCode constructor.
     * @param \QR_Code\Encoder\Input $input
     * @throws \Exception
     */
    public function __construct (Input $input)
    {
        $spec = [0, 0, 0, 0, 0];

        $this->dataCode = $input->getByteStream();
        if (is_null($this->dataCode)) {
            throw new \Exception('null imput string');
        }

        Specifications::getEccSpec($input->getVersion(), $input->getErrorCorrectionLevel(), $spec);

        $this->version = $input->getVersion();
        $this->b1 = Specifications::rsBlockNum1($spec);
        $this->dataLength = Specifications::rsDataLength($spec);
        $this->eccLength = Specifications::rsEccLength($spec);
        $this->eccCode = array_fill(0, $this->eccLength, 0);
        $this->blocks = Specifications::rsBlockNum($spec);

        $ret = $this->init($spec);
        if ($ret < 0) {
            throw new \Exception('block alloc error');
        }

        $this->count = 0;
    }

    /**
     * @param array $spec
     * @return int
     */
    public function init (array $spec) : int
    {
        $dl = Specifications::rsDataCodes1($spec);
        $el = Specifications::rsEccCodes1($spec);
        $rs = Rs::init_rs(8, 0x11d, 0, 1, $el, 255 - $dl - $el);


        $blockNo = 0;
        $dataPos = 0;
        $eccPos = 0;
        for ($i = 0; $i < Specifications::rsBlockNum1($spec); $i++) {
            $ecc = array_slice($this->eccCode, $eccPos);
            $this->rsBlocks[$blockNo] = new RsBlock($dl, array_slice($this->dataCode, $dataPos), $el, $ecc, $rs);
            $this->eccCode = array_merge(array_slice($this->eccCode, 0, $eccPos), $ecc);

            $dataPos += $dl;
            $eccPos += $el;
            $blockNo++;
        }

        if (Specifications::rsBlockNum2($spec) == 0)
            return 0;

        $dl = Specifications::rsDataCodes2($spec);
        $el = Specifications::rsEccCodes2($spec);
        $rs = Rs::init_rs(8, 0x11d, 0, 1, $el, 255 - $dl - $el);

        if ($rs == null) return -1;

        for ($i = 0; $i < Specifications::rsBlockNum2($spec); $i++) {
            $ecc = array_slice($this->eccCode, $eccPos);
            $this->rsBlocks[$blockNo] = new RsBlock($dl, array_slice($this->dataCode, $dataPos), $el, $ecc, $rs);
            $this->eccCode = array_merge(array_slice($this->eccCode, 0, $eccPos), $ecc);

            $dataPos += $dl;
            $eccPos += $el;
            $blockNo++;
        }

        return 0;
    }

    /**
     * @return int|null
     */
    public function getCode ()
    {
        $ret = null;

        if ($this->count < $this->dataLength) {
            $row = $this->count % $this->blocks;
            $col = $this->count / $this->blocks;
            if ($col >= $this->rsBlocks[0]->dataLength) {
                $row += $this->b1;
            }
            $ret = $this->rsBlocks[$row]->data[$col];
        } elseif ($this->count < $this->dataLength + $this->eccLength) {
            $row = ($this->count - $this->dataLength) % $this->blocks;
            $col = ($this->count - $this->dataLength) / $this->blocks;
            $ret = $this->rsBlocks[$row]->ecc[$col];
        } else {
            return 0;
        }
        $this->count++;

        return $ret;
    }
}