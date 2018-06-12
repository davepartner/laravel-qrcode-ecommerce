<?php

require_once __DIR__ . '/../vendor/autoload.php';

use QR_Code\Util\Tools;

Tools::clearTemporaryQRCodes();

header('Location: /');