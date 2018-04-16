<?php

namespace Devise\Pages\Slices;

use Devise\Models\DvsField;
use Devise\Models\DvsPageVersion;
use Devise\Models\DvsSliceInstance;
use Devise\Models\DvsTemplate;
use Devise\Models\DvsTemplateSlice;
use Devise\Traits\IsDeviseComponent;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class Component
{
  use IsDeviseComponent;

  protected $view;

  protected $name;

  public $component_name;

  public $component_code;

  /**
   * Component constructor.
   */
  public function __construct(SplFileInfo $file)
  {
    $this->setViewName($file->getRealPath());

    $this->name = $this->getNameFromView();

    $this->setComponentName();
    $this->setComponentCode();
  }

  private function setViewName($path)
  {
    $name = $this->getName($path);

    $path = str_replace($name, '', $path);
    $path = str_replace(resource_path('views/slices'), '', $path);
    $path = str_replace('/', '.', $path);

    $name = str_replace('.blade.php', '', $name);

    $this->view = 'slices.' . substr($path . $name, 1);
  }

  private function getName($path)
  {
    $parts = explode('/', $path);

    return $parts[count($parts) - 1];
  }

  private function setComponentName()
  {
    $this->component_name = $this->getComponentNameAttribute();
  }

  private function setComponentCode()
  {
    $this->component_code = $this->getComponentCodeAttribute();
  }
}