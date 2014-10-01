<?php namespace Devise\Support\Files;

use Config;
use Illuminate\Filesystem\Filesystem;

class FileManager extends FileSystem
{
	public $errors = array();
	private $dirPath;
	private $fileName;
	public function validatePaths($allItems)
	{
		foreach ($allItems as $item) {
			if($item['type'] == 'template' || $item['type'] == 'include')
			{
				$path = ($item['type'] == 'include') ? $item['name'] : $item['path'];
				$this->parsePath($path);
				$this->validateWritable();
			}
		}

		$this->testConfig('devise::templates');
    }

    public function saveViewFile($path, $content, $append = false)
    {
		$this->parsePath($path);
		$this->createDirIfMissing();
        if($append){
            $this->append($this->dirPath . '/' . $this->fileName, $content);
        } else {
            $this->put($this->dirPath . '/' . $this->fileName, $content);
        }
    }

    public function saveConfig($key)
    {
    	$this->setConfigVars($key);
		$this->createDirIfMissing();

		$content = $this->getConfigContent($key);
        $this->put($this->dirPath . '/' . $this->fileName, "<?php\nreturn " . $content . ";");
    }

    private function createDirIfMissing()
    {
		if(!$this->exists($this->dirPath)){
			$this->makeDirectory($this->dirPath, 0755, true);
		}
    }

    private function getConfigContent($key)
    {
        $data = Config::get($key);
        return $this->format_php_export(var_export($data,true));
    }

    private function testConfig($key)
    {
        $this->setConfigVars($key);
        $this->validateWritable();
    }

    private function setConfigVars($key)
    {
        $this->dirPath = app_path() . '/config/packages/devise/cms';
        list($package, $file) = explode('::', $key);
    	$this->fileName = $file . '.php';
    }

	private function parsePath($path)
	{
        $viewPaths = Config::get('view.paths');
        $parts = explode('.', $path);
        $this->fileName = array_pop($parts) . '.blade.php';
        $this->dirPath = $viewPaths[0] . '/' . implode('/', $parts);
	}

	private function validateWritable()
	{
		$topExistingDir = $this->findExisting($this->dirPath);
		if(!$this->isWritable($topExistingDir)){
			$this->errors[] = '"' . $topExistingDir . '" is not writable';
		}
	}

	private function findExisting($dirPath)
	{
		if($this->exists($dirPath)){
			return $dirPath;
		} else {
			return $this->findExisting($this->moveUpDir($dirPath));
		}
	}

	private function moveUpDir($dirPath)
	{
		$parts = explode('/', $dirPath);
		array_pop($parts);
		return implode('/', $parts);
	}

    private function format_php_export($arrayRep) {
        $arrayRep = str_replace('\\\\', "\\", $arrayRep);
        $arrayRep = preg_replace('/[ ]{2}/', "\t", $arrayRep);
        $arrayRep = preg_replace("/\=\>[ \n\t]+array[ ]+\(/", '=> array(', $arrayRep);
        $arrayRep = preg_replace("/\d+ => /", '', $arrayRep);
        return $arrayRep = preg_replace("/\n/", "\n\t", $arrayRep);
    }
}