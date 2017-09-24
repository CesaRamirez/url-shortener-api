<?php

namespace App\Helpers;

class Math {
        /**
         * The base.
         *
         * @var string
         */
        private static $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        /**
         * Convert from base 10 to another base.
         *
         * @param  int     $value
         * @param  int     $base
         * @return string
         */
        public static function toBase($value, $b = 62)
        {
                $r = $value  % $b;
                $result = static::$base[$r];
                $q = floor($value / $b);
                while ($q)
                {
                        $r = $q % $b;
                        $q = floor($q / $b);
                        $result = static::$base[$r].$result;
                }
                return $result;
        }
}
