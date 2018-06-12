<?php

namespace QR_Code\Encoder\ErrorCorrection;

/**
 * Class Rs
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
class Rs
{
    public static $items = [];

    /**
     * @param $symsize
     * @param $gfpoly
     * @param $fcr
     * @param $prim
     * @param $nroots
     * @param $pad
     * @return mixed|null|\QR_Code\Encoder\ErrorCorrection\RsItem
     */
    public static function init_rs ($symsize, $gfpoly, $fcr, $prim, $nroots, $pad)
    {
        foreach (self::$items as $rs) {
            if ($rs->pad != $pad) continue;
            if ($rs->nroots != $nroots) continue;
            if ($rs->mm != $symsize) continue;
            if ($rs->gfpoly != $gfpoly) continue;
            if ($rs->fcr != $fcr) continue;
            if ($rs->prim != $prim) continue;

            return $rs;
        }

        $rs = RsItem::init_rs_char($symsize, $gfpoly, $fcr, $prim, $nroots, $pad);
        array_unshift(self::$items, $rs);

        return $rs;
    }
}