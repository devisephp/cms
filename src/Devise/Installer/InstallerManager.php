<?php namespace Devise\Installer;

class InstallerManager
{
    public function __construct()
    {

    }

    public function attemptInstall()
    {
        // check if directory exists with supplied "env" value
        $path = app_path() . '/config/' . array_get($input, 'env');

        if(!\File::exists($path)) {
            \File::makeDirectory($path);

            // copy app
        }
    }

}