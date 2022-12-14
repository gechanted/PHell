<?php

namespace PHell\Flow\Main;
class Lib
{
    public static function dumpAsString($somthing)
    {
        ob_start();
        var_dump($somthing);
        return ob_get_clean();
    }
}