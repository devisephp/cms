<?php

namespace Devise;

use Devise\Http\Resources\Vue\PageResource;
use Devise\Http\Resources\Vue\SiteResource;
use Devise\Models\DvsSite;

/**
 * @todo refactor to a facade pattern
 */
class Devise
{
  private static $components = [];

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

  public static function addComponent($name, $object)
  {
    if (!isset(self::$components[$name]))
    {
      self::$components[$name] = self::compress_script($object);
    }
  }

  public static function pageData($page)
  {
    $resource = new PageResource($page);

    return "window.page = " . json_encode($resource->toArray(request())) . ";\n";
  }

  private static function compress_script($buffer)
  {
    $replace = array(
      '#\'([^\n\']*?)/\*([^\n\']*)\'#' => "'\1/'+\'\'+'*\2'",
      '#\"([^\n\"]*?)/\*([^\n\"]*)\"#' => '"\1/"+\'\'+"*\2"',
      '#/\*.*?\*/#s'                   => "",
      '#[\r\n]+#'                      => "\n",
      '#\n([ \t]*//.*?\n)*#s'          => "\n",
      '#([^\\])//([^\'"\n]*)\n#s'      => "\\1\n",
      '#\n\s+#'                        => "\n",
      '#\s+\n#'                        => "\n",
      '#(//[^\n]*\n)#s'                => "\\1\n",
      '#/([\'"])\+\'\'\+([\'"])\*#'    => "/*"
    );

    $search = array_keys($replace);
    $script = preg_replace($search, $replace, $buffer);

    $replace = array(
      "&&\n" => "&&",
      "||\n" => "||",
      "(\n"  => "(",
      ")\n"  => ")",
      "[\n"  => "[",
      "]\n"  => "]",
      "+\n"  => "+",
      ",\n"  => ",",
      "?\n"  => "?",
      ":\n"  => ":",
      ";\n"  => ";",
      "{\n"  => "{",
      "\n]"  => "]",
      "\n)"  => ")",
      "\n}"  => "}",
      "\n\n" => "\n"
    );

    $search = array_keys($replace);
    $script = str_replace($search, $replace, $script);

    return trim($script);

  }
}