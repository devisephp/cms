<?php

namespace Devise;

use Devise\Http\Resources\Vue\PageResource;
use Devise\Http\Resources\Vue\SiteResource;
use Devise\Http\Resources\Vue\TemplateResource;
use Devise\Models\DvsPage;
use Devise\Models\DvsSite;

use Devise\MotherShip\DvsRelease;
use Devise\Sites\SiteDetector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * @todo refactor to a facade pattern
 */
class Devise
{
  private static $components = [];

  public static function data($page)
  {
    $js = 'function Devise(){}';
    $js .= self::user();
  
    if (get_class($page) == DvsPage::class)
    {
      $js .= self::sites();
      $js .= self::pageData($page);

      if (Auth::user()) {
        $js .= self::mothership();
        $js .= self::interface();
      }
    } else
    {
      $js .= self::template($page);
    }

    $js .= self::components();

    $js .= 'var deviseSettings = new Devise()';

    return $js;
  }

  public static function dataAsArray($page)
  {
    $resource = new PageResource($page);

    return [
      'page' => $resource->toArray(request())
    ];
  }

  public static function sites()
  {
    $detector = App::make(SiteDetector::class);
    $sites = $detector->all();

    $resource = SiteResource::collection($sites);

    return 'Devise.prototype.$sites = ' . json_encode($resource->toArray(request())) . ";\n";
  }

  public static function components()
  {
    return 'Devise.prototype.$deviseComponents = {' . implode(',', self::$components) . "};\n";
  }

  public static function mothership()
  {
    return 'Devise.prototype.$mothership = ' . json_encode(config('devise.mothership')) . ";\n";
  }

  public static function interface()
  {
    return 'Devise.prototype.$interface = ' . json_encode(config('devise.interface')) . ";\n";
  }

  public static function pageData($page)
  {
    $resource = new PageResource($page);

    return 'Devise.prototype.$page = ' . json_encode($resource->toArray(request())) . ";\n";
  }

  public static function template($template)
  {
    $resource = new TemplateResource($template);

    return 'Devise.prototype.$template = ' . json_encode($resource->toArray(request())) . ";\n";
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
    return 'Devise.prototype.$user = ' . json_encode(Auth::user()) . ";\n";
  }

  public static function mothershipEnabled()
  {
    $releasesCount = DvsRelease::where('model_name', 'Release')
      ->count();

    return (Schema::hasTable('dvs_releases') && $releasesCount > 0);
  }
}
