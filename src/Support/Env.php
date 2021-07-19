<?php namespace Devise\Support;

class Env
{
    public static function set($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = env($envKey);

        if ($oldValue)
        {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);
        } else
        {
            $str .= "\n{$envKey}={$envValue}";
        }

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}