<?php


namespace App\Helpers;


class Utils
{
    public static function money2Float($currency_amt)
    {
       return floatval(preg_replace('/[^\d\.]/', '', $currency_amt));
    }
}