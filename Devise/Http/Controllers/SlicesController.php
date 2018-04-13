<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class SlicesController extends Controller
{
  private $data = [];

  public function all(ApiRequest $request)
  {
    $all = File::allFiles(resource_path('views/slices'));

    $options = [];

    foreach ($all as $file)
    {
      $path = str_replace(resource_path('views/slices'), '', $file->getPath());

      if($path){
        $path = substr($path, 1);
        $path = str_replace('/','.', $path);
      }

      $this->addFile([
        'path' => $path,
        'name' => $this->getName($file->getFilename()),
        'view' => $this->getViewName($path, $file->getFilename())
      ]);
    }
  }

  private function getName($getFilename)
  {
    $name = str_replace('.blade.php','', $getFilename);
    $name = str_replace('-',' ', $name);

    return ucwords($name);
  }

  private function getViewName($path, $getFilename)
  {
    $name = str_replace('.blade.php','', $getFilename);

    $path = $path ? $path . '.' : '';

    return $path . $name;
  }

  private function addFile($file)
  {
    if($file['path']){

      $directories = explode('.', $file['path']);
      $depth = count($directories);

      foreach ($this->data as $data){
        if(!isset($data['directories'])){
          $data['directories'] = [
            'directories' => []
          ];
        }
      }

    } else {
      $this->data[] = $file;
    }
  }
}