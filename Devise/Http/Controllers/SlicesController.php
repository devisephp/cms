<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class SlicesController extends Controller
{

  public function all(ApiRequest $request)
  {
    $slices = [];
    $directories = $this->scanSlicesDir(resource_path('views/slices'));
    return $this->flattenSlice($slices, $directories);
  }

  function flattenSlice ($slices, $directories) {
    $slices = array_merge($slices, $directories['files']);
    foreach($directories['directories'] as $directory) {
      $slices = array_merge($slices, $this->flattenSlice($slices, $directory));
    }

    return $slices;
  }

  public function allDirectories(ApiRequest $request)
  {
    return $this->scanSlicesDir(resource_path('views/slices'));
  }

  function scanSlicesDir($dir)
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
            'value' => $this->getViewName($path)
          ];
        } else
        {
          $results = $this->scanSlicesDir($path);
          $directories[] = $results;
        }
      }
    }

    return [
      'name'        => $this->getDirName($dir),
      'directories' => $directories,
      'files'       => $files
    ];
  }

  private function getFileName($path)
  {
    $name = $this->getName($path);
    $name = str_replace('.blade.php', '', $name);

    return $this->toHuman($name);
  }

  private function getViewName($path)
  {
    $name = $this->getName($path);

    $path = str_replace($name, '', $path);
    $path = str_replace(resource_path('views/slices'), '', $path);
    $path = str_replace('/', '.', $path);

    $name = str_replace('.blade.php', '', $name);

    return substr($path . $name, 1);
  }

  private function getDirName($path)
  {
    $path = $this->getName($path);

    if ($path == "") return 'Slices';

    return $this->toHuman($path);
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
