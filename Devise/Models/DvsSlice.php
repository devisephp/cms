<?php

namespace Devise\Models;

use Illuminate\Support\Facades\View;

class DvsSlice extends Model
{
  protected $fillable = array('name', 'view');

  protected $table = 'dvs_slices';

  public function getComponentNameAttribute()
  {
    return 'Devise' . studly_case(preg_replace('/[^A-Za-z0-9\-]/', '', $this->name));
  }

  public function pageVersions()
  {
    return $this->belongsToMany(DvsPageVersion::class, 'dvs_slice_instances', 'slice_id', 'page_version_id');
  }

  public function getComponentCodeAttribute()
  {
    $view = View::make($this->view);

    $sections = $view->renderSections();

    $component = $sections['component'];
    $template = $this->cleanHtml($sections['template']);

    preg_match("#<\s*?script\b[^>]*>(.*?)</script\b[^>]*>#s", $component, $match);
    $javascript = $match[1];

    $parts = explode('{', $javascript);

    array_shift($parts);
    $partial = trim(implode('{', $parts));

    $name = $this->component_name;

    $code = $name . ": {name:\"" . $name . "\",template:\"" . $template . "\"," . $partial;

    return $this->compress_script($code);
  }

  private function cleanHtml($html)
  {
    $html = preg_replace(
      array(
        '/ {2,}/',
        '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
      ),
      array(
        ' ',
        ''
      ),
      $html
    );

    return trim(addslashes($html));
  }

  private function compress_script($buffer)
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