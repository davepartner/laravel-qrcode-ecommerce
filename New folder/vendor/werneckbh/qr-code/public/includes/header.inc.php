<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use QR_Code\Types\QR_Text;
use QR_Code\Util\Benchmark;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';

//of course we need rights to create temp dir
if (!file_exists(TEMP_DIR)) {
    mkdir(TEMP_DIR);
}

//processing form input

$defaultErrorCorrectionLevel = 'L';
$defaultMatrixPointSize = 4;
$defaultData = 'QR Code Generator for PHP!';

// Level of Error Correction
$level = filter_input(INPUT_POST, 'level') ?: $defaultErrorCorrectionLevel;
$errorCorrectionLevel = validateErrorCorrectionLevel($level) ? $level : $defaultErrorCorrectionLevel;

// Pixel size
$size = filter_input(INPUT_POST, 'size') ?: $defaultMatrixPointSize;
$matrixPointSize = min(max((int) $size, 1), 10);

// Data to Encode
$data = trim(filter_input(INPUT_POST, 'data')) ?: $defaultData;

// Output file PNG or SVG
// ** As of the moment, filter_input does NOT support INPUT_REQUEST flag
$output = isset($_REQUEST['output']) ? $_REQUEST['output'] : 'png';

$filename = TEMP_DIR . 'test.' . $output;

if ($data !== $defaultData) {
    // $data is new, generate new QR Code

    // Create temporary filename (new permutations will be overwritten)
    $filename = TEMP_DIR . 'qr_code_' . md5($data . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.' . $output;

    // Stream QR Code image
    $qr = new QR_Text($data);
    $qr
        ->setOutfile($filename)
        ->setErrorCorrectionLevel($errorCorrectionLevel)
        ->setSize($matrixPointSize)
        ->setMargin(2)
        ->{$output}();
}

// Show Benchmark form if form sent benchmark flag
$showBenchmark = filter_input(INPUT_POST, 'benchmark') ? $benchmarkResults = Benchmark::getResults() : false;

