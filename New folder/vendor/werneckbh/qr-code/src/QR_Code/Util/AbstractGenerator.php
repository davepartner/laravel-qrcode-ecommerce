<?php

namespace QR_Code\Util;

use QR_Code\Contracts\CodeType;
use QR_Code\QR_Code;

/**
 * Class AbstractGenerator
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Util
 */
abstract class AbstractGenerator
{
    /**
     * @var \QR_Code\Contracts\CodeType
     */
    protected $codeType;
    /**
     * @var bool|string
     */
    protected $outfile = false;
    /**
     * @var string
     */
    protected $errorCorrectionLevel = 'L';
    /**
     * @var int
     */
    protected $size = 3;
    /**
     * @var int
     */
    protected $margin = 4;
    /**
     * @var bool
     */
    protected $saveAndPrint = false;
    /**
     * @var int
     */
    protected $backColor = QR_WHITE;
    /**
     * @var int
     */
    protected $foreColor = QR_BLACK;

    /**
     * @param bool|string $outfile
     * @return AbstractGenerator
     */
    public function setOutfile ($outfile)
    {
        if (is_string($outfile)) {
            $this->outfile = $outfile;
        }

        return $this;
    }

    /**
     * @param string $errorCorrectionLevel
     * @return AbstractGenerator
     */
    public function setErrorCorrectionLevel (string $errorCorrectionLevel) : AbstractGenerator
    {
        $this->errorCorrectionLevel = $errorCorrectionLevel;
        return $this;
    }

    /**
     * @param int $size
     * @return AbstractGenerator
     */
    public function setSize (int $size) : AbstractGenerator
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param int $margin
     * @return AbstractGenerator
     */
    public function setMargin (int $margin) : AbstractGenerator
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * @param bool $saveAndPrint
     * @return AbstractGenerator
     */
    public function setSaveAndPrint (bool $saveAndPrint) : AbstractGenerator
    {
        $this->saveAndPrint = $saveAndPrint;
        return $this;
    }

    /**
     * @param int $backColor
     * @return AbstractGenerator
     */
    public function setBackColor (int $backColor) : AbstractGenerator
    {
        $this->backColor = $backColor;
        return $this;
    }

    /**
     * @param int $foreColor
     * @return AbstractGenerator
     */
    public function setForeColor (int $foreColor) : AbstractGenerator
    {
        $this->foreColor = $foreColor;
        return $this;
    }


    /**
     * Stream and/or save PNG QR Code
     */
    public function png () : void
    {
        QR_Code::png($this->getCodeString(), $this->outfile, $this->errorCorrectionLevel, $this->size, $this->margin, $this->saveAndPrint, $this->backColor, $this->foreColor);
    }

    /**
     * Stream and/or save SVG QR Code
     */
    public function svg () : void
    {
        QR_Code::svg($this->getCodeString(), $this->outfile, $this->errorCorrectionLevel, $this->size, $this->margin, $this->saveAndPrint, $this->backColor, $this->foreColor);
    }

    /**
     * Get Code String to be encoded into QR Code
     *
     * @return string Code String
     */
    abstract public function getCodeString () : string;
}