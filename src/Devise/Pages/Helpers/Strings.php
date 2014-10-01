<?php namespace Devise\Pages\Helpers;

class Strings {

    public static function fromHuman($name)
    {
        return strtolower(
            preg_replace("/[^A-Za-z0-9_]/","",
                str_replace(" ", "_", 
                    preg_replace("/\s+/", " ", $name)
                )
            )
        );
    }
}