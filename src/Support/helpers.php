<?php

use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

if (!function_exists('vuemix'))
{
    /**
     * Get the path to a versioned Mix file.
     *
     * @param  string $path
     * @param  string $manifestDirectory
     * @return \Illuminate\Support\HtmlString|string
     *
     * @throws \Exception
     */
    function vuemix($path, $manifestDirectory = '')
    {
        $hotFilePath = public_path($manifestDirectory . '/hot');
        $pathParts = explode(DIRECTORY_SEPARATOR, $path);
        $file = $pathParts[count($pathParts) - 1];

        
        // check if HMR server is running via helper file 'hot'
        if (file_exists($hotFilePath))
        {
            // Everything is bundled in the app.js so only include it
            $hotFile = file($hotFilePath);
            $resourcePath = 'http://atlantisbahamas-d2.test:8080/app' . $path;
            
            return new HtmlString($resourcePath);
        }

        // HMR isn't loading so check the manifest and return the hashed file
        $manifestFilePath = public_path($manifestDirectory . '/manifest.json');
        $manifestFile = file_get_contents($manifestFilePath);
        $manifest = json_decode($manifestFile);

        return new HtmlString($manifestDirectory . DIRECTORY_SEPARATOR . $manifest->$file); // return path without changing anything aka production
    }
}