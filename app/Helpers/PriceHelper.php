<?php

namespace App\Helpers;

class PriceHelper
{
    public static function format($price)
    {
        if (!is_numeric($price)) {
            return $price;
        }

        return fmod($price, 1) == 0
            ? number_format($price, 0)
            : number_format($price, 2);
    }
}
