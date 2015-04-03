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
     * Retrives only the config array from the app's file. exclude's the package's config
     *
     * @param  string $dothPath
     * @return array
     */
    public function getAppOnly($dotPath)
    {
        $filePathFromConfig = implode('/', explode('.', $dotPath)) . '.php';
        $path = config_path($filePathFromConfig);
        if($this->files->exists($path)){
            return require $path;
        }
        return array();
    }

    /**
     * Retrives and writes/saves supplied content to specified config file
     *
     * @param  string $content
     * @param  string $filename
     * @return string | boolean
     */
    public function saveToFile($content, $filename)
    {
        $configFile = $this->getFileByEnvironment($filename);

        $this->files->put($configFile, '<?php return ' . $this->prettyVarExport($content) . ';');

        sleep(2); // hack to force the file to update on the next request. @todo look at asap

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
     * Retrieves config file
     *
     * @param  string $filename
     * @return \Exception
     */
    private function getFileByEnvironment($filename)
    {
        // set path to published config location
        $path = config_path() . '/devise';

        if(!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path,  0755, true);
        }

        $file = $path . "/{$filename}.php";

        if($this->files->isDirectory($path) ) {
            return $file;
        }

        throw new \Exception($path . ' is not a directory');
    }

}