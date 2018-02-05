<?php

namespace Devise;

use Devise\Resources\PageDataResource;

class Devise
{
  private static $components = [];

  public static function components()
  {
    return "window.deviseComponents = {\n" . implode(',', self::$components) . "};\n";
  }

  public static function addComponent($object)
  {
    self::$components[] = $object;
  }

  public static function pageData($page)
  {
    $resource = new PageDataResource($page);

    return "window.page = " . json_encode($resource->toArray(request())) . ";\n";
  }
}