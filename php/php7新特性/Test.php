<?php

/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2018/12/23
 * Time: 14:02
 */
class Test
{

    CONST PHP7_ARRAY_CONST = [
       'AA','BB','CC'
    ];

     public function go()
     {
         goto AA;

         AA:

     }

     public function get($file):void
     {
         $handle = fopen($file, 'r');
         if ($handle !== false)
         {
             return $handle;
         }
     }

}