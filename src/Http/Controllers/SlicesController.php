<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Devise\Models\DvsSliceInstance;
use Illuminate\Routing\Controller;

class SlicesController extends Controller
{

    public function allDirectories(ApiRequest $request)
    {
        return $this->scanSlicesDir(resource_path('views/slices'));
    }

    private function flattenDirectory($directory)
    {
        $slices = [];

        if (isset($directory['files']))
        {
            $slices = $directory['files'];
        }

        if (isset($directory['directories']))
        {
            foreach ($directory['directories'] as $directory)
            {
                $slices = array_merge($slices, $this->flattenDirectory($directory));
            }
        }

        return $slices;
    }

    private function scanSlicesDir($dir)
    {
        if (is_dir($dir))
        {
            $found = scandir($dir);

            $directories = [];
            $files = [];

            foreach ($found as $key => $value)
            {
                $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

                if ($value != "." && $value != ".." && $value != ".DS_Store")
                {
                    if (!is_dir($path))
                    {
                        $files[] = [
                            'name'  => $this->getFileName($path),
                            'value' => $this->getViewPath($path)
                        ];
                    } else
                    {
                        $results = $this->scanSlicesDir($path);
                        $directories[] = $results;
                    }
                }
            }

            return [
                'name'        => $this->getHumanName($dir),
                'path'        => $this->getDirPath($dir),
                'dirName'     => $this->getDirName($dir, false),
                'directories' => $directories,
                'files'       => $files
            ];
        }

        return [];
    }

    private function getFileName($path)
    {
        $name = $this->getName($path);
        $name = str_replace('.blade.php', '', $name);

        return $this->toHuman($name);
    }

    private function getViewPath($path)
    {
        $name = $this->getName($path);

        $path = str_replace($name, '', $path);
        $path = str_replace(resource_path('views/slices'), '', $path);
        $path = str_replace('/', '.', $path);

        $name = str_replace('.blade.php', '', $name);

        return substr($path . $name, 1);
    }

    private function getHumanName($path)
    {
        $path = $this->getName($path);

        if ($path == "") return 'Slices';

        return $this->toHuman($path);
    }

    private function getDirPath($path)
    {
        $path = str_replace(resource_path('views/slices'), '', $path);
        $path = str_replace('/', '.', $path);

        return substr($path, 1);
    }

    private function getDirName($path, $human = true)
    {
        $path = $this->getName($path);
        if ($path == "") return 'Slices';
        
        if ($human) {	        
            return $this->toHuman($path);	
        }
        return $path;
    }

    private function toHuman($string)
    {
        $string = preg_replace("/[^a-zA-Z]/", " ", $string);

        return ucwords($string);
    }

    private function getName($path)
    {
        $parts = explode('/', $path);

        return $parts[count($parts) - 1];
    }
}
