<?php namespace Devise\Support\Config;

use \Illuminate\Filesystem\Filesystem as Filesystem;

/**
 * Class FileManager is used to manage retrieving and modifying
 * Devise config(s) files along with any other management functions
 *
 * @package Devise\Config\FileManager
 */
class FileManager
{
    protected $Filesystem;

    public function __construct(Filesystem $Filesystem)
    {
        $this->files = $Filesystem;
    }

    /**
     * Retrives and writes/saves supplied content to specified config file
     *
     * @param  string $content
     * @param  string $filename
     * @param  string $package  Vendor/Package string (ex: devisephp/cms)
     * @return string | boolean
     */
    public function saveToFile($content, $filename, $package)
    {
        $configFile = $this->getFileByEnvironment($filename, $package);

        \File::put($configFile, '<?php return ' . $this->prettyVarExport($content) . ';');
        
        sleep(1); // hack to force the file to update on the next request. @todo look at asap

        return $content;
    }

    /**
     * Formats/cleans var_export for writing to config file
     *
     * @param  string $content
     * @return string
     */
    private function prettyVarExport($content) {
        $arrayRep = var_export($content, true);
        $arrayRep = str_replace('\\\\', "\\", $arrayRep);
        $arrayRep = preg_replace('/[ ]{2}/', "\t", $arrayRep);
        $arrayRep = preg_replace("/\=\>[ \n\t]+array[ ]+\(/", '=> array(', $arrayRep);
        $arrayRep = preg_replace("/\d+ => /", '', $arrayRep);

        return $arrayRep = preg_replace("/\n/", "\n\t", $arrayRep);
    }

    /**
     * Retrieves config file by using the environment and/or
     * vendor/package to build file paths to check; the paths are
     * ordered with app dirs first, workbench second and vendor third
     *
     * @param  string $filename
     * @param  string $package
     * @return \Exception
     */
    private function getFileByEnvironment($filename, $package = null)
    {
        // set path to published config location
        $path = config_path() . '/devise';

        if(!\File::isDirectory($path)) {
            \File::makeDirectory($path,  755, true);
        }

        $file = $path . "/devise.{$filename}.php";

        if(\File::isDirectory($path) ) {
            return $file;
        }

        throw new \Exception($path . ' is not a directory');
    }

}