<?php


namespace App\Helpers;


class Utils
{
    public static function money2Float($currency_amt)
    {
       return floatval(preg_replace('/[^\d\.]/', '', $currency_amt));
    }
    public static function hasRole($role, $rolesArray)
    {
        foreach($rolesArray as $rol){
            if(trim($rol->name) == trim($role))
                return true;
        }
        return false;
    }
}