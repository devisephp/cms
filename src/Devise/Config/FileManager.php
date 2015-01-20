<?php namespace Devise\Config;

use \Illuminate\Filesystem\Filesystem as Filesystem;

/**
 * Class FileManager is used to manage retrieving and modifying
 * Devise config(s) files along with any other management functions
 *
 * @package Devise\Config\FileManager
 */
class FileManager extends \Illuminate\Config\FileLoader
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
     * @param  string $environment
     * @param  string $filename
     * @param  string $package  Vendor/Package string (ex: devisephp/cms)
     * @return string | boolean
     */
    public function saveToFile($content, $environment, $filename, $package)
    {
        $configFile = $this->getFileByEnvironment($environment, $filename, $package);

        if($configFile) {
            file_put_contents($configFile, '<?php return ' . $this->prettyVarExport($content) . ';');

            return $content;
        }

        return false;
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
     * @param  string $environment
     * @param  string $filename
     * @param  string $package
     * @return string | boolean
     */
    private function getFileByEnvironment($environment, $filename, $package = null)
    {
        // define paths array with default/app config path
        $pathsArr = [ app_path() . '/config' ];

        // if package specified, add workbench & vendor paths to array
        if($package != '')
        {
            $pathsArr[] = app_path() . '/../workbench/' . $package . '/src/config';
            $pathsArr[] = app_path() . '/../vendor/' . $package . '/src/config';
        }

        // iterates thru paths in and returns first string
        // which is a valid directory and valid file
        foreach($pathsArr as $path)
        {
            $path = (!$environment || ($environment == 'production'))
                ? "{$path}/"
                : "{$path}/{$environment}/";

            $file = $path . "{$filename}.php";

            if(\File::isDirectory($path) && \File::isFile($file)) {
                return $file;
            }
        }

        return false;
    }

}