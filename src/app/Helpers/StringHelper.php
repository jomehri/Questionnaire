<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param int $length
     * @return string
     */
    public static function randomNumber(int $length): string
    {
        $i = 0;
        $result = '';

        while($i < $length){
            $result .= mt_rand(0, 9);
            $i++;
        }

        return $result;
    }
}
