<?php

/**
 * fun::getFun("JSON");
 * 
 */
class fun
{
    public static function getFun($fun)
    {
        return get_extension_funcs($fun);
    }

    public static function regFun($class, $fun)
    {
    }

}
