<?php

namespace Devise\Models;

use Illuminate\Support\Facades\View;

class DvsTemplateSlice extends Model
{
  protected $fillable = ['template_id', 'parent_id', 'slice_id', 'label', 'position', 'view'];

  protected $table = 'dvs_template_slice';

  protected $attributes = [
    'model_query' => '',
    'config' => ''
  ];

  private $hasSliceSlot = false;

  /**
   *
   */
  public function slices()
  {
    return $this->hasMany(DvsTemplateSlice::class, 'parent_id')
      ->orderBy('position');
  }

  public function setConfigAttribute($value)
  {
    $this->attributes['config'] = ($value) ? json_encode($value) : "";
  }

  public function getConfigAttribute($value)
  {
    return json_decode($value);
  }

  public function getComponentNameAttribute()
  {
    return 'Devise' . studly_case(preg_replace('/[^A-Za-z0-9\-]/', '', $this->name));
  }

  public function getHasChildSlotAttribute()
  {
    return $this->hasSliceSlot;
  }

  public function getComponentCodeAttribute()
  {
    $view = View::make($this->view);

    $sections = $view->renderSections();

    $component = $sections['component'];

    $this->detectSlotAvailability($sections);

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

  private function detectSlotAvailability($sections)
  {
    $this->hasSliceSlot = (strpos($sections['template'], '<slices') !== false);

    if(!$this->hasSliceSlot){
      $this->hasSliceSlot = ((strpos($sections['component'], 'hasChildSlot: true') !== false) || (strpos($sections['component'], 'hasChildSlot:true') !== false));
    }
  }
}