<?php

function mod11($baseVal = "", $separator = '-')
{
    $result = "";
    $weight = [ 2, 3, 4, 5, 6, 7,
        2, 3, 4, 5, 6, 7,
        2, 3, 4, 5, 6, 7,
        2, 3, 4, 5, 6, 7 ];
    /* For convenience, reverse the string and work left to right. */
    $reversedBseVal = strrev($baseVal);
    for ($i=0, $sum=0; $i < strlen($reversedBseVal); $i++) {
        /* Calculate product and accumulate. */
        $sum += substr($reversedBseVal, $i, 1) * $weight[$i];
    }
    /* Determine check digit, and concatenate to base value. */
    $remainder = $sum % 11;
    switch ($remainder) {
        case 0:
            $result = "{$baseVal}{$separator}0";
            break;
        case 1:
            $result = "{$baseVal}{$separator}X";
            break;
        default:
            $checkDigit = 11 - $remainder;
            $result = "{$baseVal}{$separator}{$checkDigit}";
            break;
    }
    return $result;
}

var_dump(mod11('7774520610','-'));

//http://redmine.uco.com/redmine/attachments/download/30562/ems_yy.sql

//http://redmine.uco.com/redmine/attachments/download/30563/ems_3p.sql