<?php

/**
 * Directories
 */
defined('DROP_ONE_LEVEL') ?: define('DROP_ONE_LEVEL', DIRECTORY_SEPARATOR . '..');

defined('TEMP_DIR') ?: define('TEMP_DIR',
    __DIR__ .
    DROP_ONE_LEVEL .
    DROP_ONE_LEVEL .
    DIRECTORY_SEPARATOR . 'public' .
    DIRECTORY_SEPARATOR . 'temp' .
    DIRECTORY_SEPARATOR
);

defined('QR_CACHE_DIR') ?: define('QR_CACHE_DIR',
    __DIR__ .
    DROP_ONE_LEVEL .
    DIRECTORY_SEPARATOR . 'cache' .
    DIRECTORY_SEPARATOR
);
defined('QR_LOG_DIR') ?: define('QR_LOG_DIR',
    __DIR__ .
    DROP_ONE_LEVEL .
    DIRECTORY_SEPARATOR . 'logs' .
    DIRECTORY_SEPARATOR
);

/**
 * Encoding Modes
 */
defined('QR_MODE_NUL') ?: define('QR_MODE_NUL', -1);
defined('QR_MODE_NUM') ?: define('QR_MODE_NUM', 0);
defined('QR_MODE_AN') ?: define('QR_MODE_AN', 1);
defined('QR_MODE_8') ?: define('QR_MODE_8', 2);
defined('QR_MODE_KANJI') ?: define('QR_MODE_KANJI', 3);
defined('QR_MODE_STRUCTURE') ?: define('QR_MODE_STRUCTURE', 4);

/**
 * Levels of Error Correction
 */
defined('QR_ECLEVEL_L') ?: define('QR_ECLEVEL_L', 0);
defined('QR_ECLEVEL_M') ?: define('QR_ECLEVEL_M', 1);
defined('QR_ECLEVEL_Q') ?: define('QR_ECLEVEL_Q', 2);
defined('QR_ECLEVEL_H') ?: define('QR_ECLEVEL_H', 3);

/**
 * Supported Output Formats
 */
defined('QR_FORMAT_TEXT') ?: define('QR_FORMAT_TEXT', 0);
defined('QR_FORMAT_PNG') ?: define('QR_FORMAT_PNG', 1);

/**
 * QR Code
 */
defined('QR_CACHEABLE') ?: define('QR_CACHEABLE', false);

defined('QR_FIND_BEST_MASK') ?: define('QR_FIND_BEST_MASK', true);
defined('QR_FIND_FROM_RANDOM') ?: define('QR_FIND_FROM_RANDOM', 2);
defined('QR_DEFAULT_MASK') ?: define('QR_DEFAULT_MASK', 2);

defined('QR_PNG_MAXIMUM_SIZE') ?: define('QR_PNG_MAXIMUM_SIZE', 1024);

/**
 * QR Code Specifications
 */
defined('QRSPEC_VERSION_MAX') ?: define('QRSPEC_VERSION_MAX', 40);
defined('QRSPEC_WIDTH_MAX') ?: define('QRSPEC_WIDTH_MAX', 177);

defined('QRCAP_WIDTH') ?: define('QRCAP_WIDTH', 0);
defined('QRCAP_WORDS') ?: define('QRCAP_WORDS', 1);
defined('QRCAP_REMINDER') ?: define('QRCAP_REMINDER', 2);
defined('QRCAP_EC') ?: define('QRCAP_EC', 3);

/**
 * QR Image
 */
defined('QR_IMAGE') ?: define('QR_IMAGE', true);

/**
 * QR Input
 */
defined('STRUCTURE_HEADER_BITS') ?: define('STRUCTURE_HEADER_BITS', 20);
defined('MAX_STRUCTURED_SYMBOLS') ?: define('MAX_STRUCTURED_SYMBOLS', 16);

/**
 * QR Vector
 */
defined('QR_VECT') ?: define('QR_VECT', true);

/**
 * QR Mask
 */
defined('N1') ?: define('N1', 3);
defined('N2') ?: define('N2', 3);
defined('N3') ?: define('N3', 40);
defined('N4') ?: define('N4', 10);

/**
 * Colors
 */

defined('QR_WHITE') ?: define('QR_WHITE', 0xFFFFFF);
defined('QR_BLACK') ?: define('QR_BLACK', 0x000000);
defined('QR_RED') ?: define('QR_RED', 0xFF0000);
defined('QR_GREEN') ?: define('QR_GREEN', 0x00FF00);
defined('QR_BLUE') ?: define('QR_BLUE', 0x0000FF);;