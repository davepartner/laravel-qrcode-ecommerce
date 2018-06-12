<?php

namespace QR_Code\Types;

use QR_Code\Contracts\CodeType;
use QR_Code\Util\AbstractGenerator;

/**
 * Class QR_EmailMessage
 *
 * QR Code Generator for PHP is distributed under MIT
 * Copyright (C) 2018 Bruno Vaula Werneck <brunovaulawerneck at gmail dot com>
 *
 * @package QR_Code\Types
 */
class QR_EmailMessage extends AbstractGenerator implements CodeType
{
    protected $email;
    protected $message;
    protected $subject;

    /**
     * Email Message QR Code
     *
     * @param string $email Email address
     * @param string $message Email Message Body
     * @param string $subject Email subject
     */
    public function __construct(string $email, string $message, string $subject)
    {
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Get Formatted QR Code String
     *
     * @return string
     */
    public function getCodeString () : string
    {
        return "MATMSG:TO:{$this->email};SUB:{$this->subject};BODY:{$this->message};;";
    }
}