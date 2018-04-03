<?php

namespace Devise;

use Devise\Http\Resources\Vue\PageResource;
use Devise\Http\Resources\Vue\SiteResource;
use Devise\Http\Resources\Vue\TemplateResource;
use Devise\Models\DvsPage;
use Devise\Models\DvsSite;
use Devise\Models\DvsSlice;
use Illuminate\Support\Facades\Auth;

/**
 * @todo refactor to a facade pattern
 */
class Devise
{
  private static $components = [];

  public static function data($page)
  {
    $js = self::user();

    if (get_class($page) == DvsPage::class)
    {
      $js .= self::sites();
      $js .= self::pageData($page);
    } else
    {
      $js .= self::template($page);
    }

    $js .= self::components();

    return $js;
  }

  public static function sites()
  {
    $sites = DvsSite::with('languages')->get();

    $resource = SiteResource::collection($sites);

    return "window.sites = " . json_encode($resource->toArray(request())) . ";\n";
  }

  public static function components()
  {
    return "window.deviseComponents = {" . implode(',', self::$components) . "};\n";
  }

  public static function pageData($page)
  {
    $resource = new PageResource($page);

    return "window.page = " . json_encode($resource->toArray(request())) . ";\n";
  }

  public static function template($template)
  {
    $resource = new TemplateResource($template);

    return "window.template = " . json_encode($resource->toArray(request())) . ";\n";
  }

  public static function addComponent($slice)
  {
    $name = $slice->component_name;
    if (!isset(self::$components[$name]))
    {
      self::$components[$name] = $slice->component_code;
    }
  }

  public static function user()
  {
    return "window.user = " . json_encode(Auth::user()) . ";\n";
  }
}