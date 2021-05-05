<?php

namespace App\DisplayUtil;

class DisplayNumberUtil
{
    /*
    public static function getDisplayNumberString($number)
    {
        //$oneDigitNumberStringArray = [ '０', '１', '２', '３', '４', '５', '６', '７', '８', '９' ];
        $oneDigitNumberStringArray = [ ' 0 ', ' 1 ', ' 2 ', ' 3 ', ' 4 ', ' 5 ', ' 6 ', ' 7 ', ' 8 ', ' 9 ' ];
        
        $displayNumberString = $number;
        
        if(0 <= $number && $number < 10) {
            $displayNumberString = $oneDigitNumberStringArray[$number];
        }
        return $displayNumberString;
    }
    */
    public static function getDisplayNumberString($number)
    {
        $displayNumberString = ' ' . $number . ' ';
        return $displayNumberString;
    }
}