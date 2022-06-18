<?php

namespace FincanaTest\Helpers;

class ArrayHelper extends Helper
{
    /**
     * Search in array of strings element with starts with $needle
     * if not found return `false`, else return index of element
     *
     * @param string $needle
     * @param array  $arr
     *
     * @return int|false
     */
    public static function startsWith(string $needle, array $arr)
    {
        for ($i = 0; $i < count($arr); $i++) {
            if (str_starts_with($arr[$i], $needle)) {
                return $i;
            }
        }

        return false;
    }
}
