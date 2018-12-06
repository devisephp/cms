<?php

namespace Devise\Traits;

use Illuminate\Support\Facades\View;

/**
 * Trait IsDeviseComponent
 * @package App\Traits
 */
trait IsDeviseComponent
{
    private $hasSliceSlot = false;

    private $viewSections = false;

    public function getNameAttribute($value)
    {
        return $this->getNameFromView();
    }

    public function getComponentNameAttribute()
    {
        return 'Devise' . studly_case(preg_replace('/[^A-Za-z0-9\-]/', '', $this->name));
    }

    public function getHasChildSlotAttribute()
    {
        return $this->hasSliceSlot;
    }

    public function getHasChildSlotStringAttribute()
    {
        return $this->hasSliceSlot ? 'true' : 'false';
    }

    public function getComponentCodeObjectAttribute()
    {
        $sections = $this->getViewSections();

        $template = $this->cleanHtml($sections['template']);

        $partial = $this->getComponentScript($sections['component']);

        return "{name:\"" . $this->component_name . "\",view:\"" . $this->view . "\",template:\"" . $template . "\",has_child_slot:true," . $partial;
    }

    public function getComponentCodeAttribute()
    {
        $code = $this->component_name . ": " . $this->component_code_object;

        return $this->compress_script($code);
    }

    public function getTemplateHtml()
    {
        $sections = $this->getViewSections();

        return $this->cleanHtml($sections['template']);
    }

    public function getComponentAsArray()
    {
        $sections = $this->getViewSections();

        $partial = $this->getComponentScript($sections['component']);
        $str = preg_replace('/(\w+)\s{0,1}:/', '"\1":', str_replace(array("\r\n", "\r", "\n", "\t"), "", '{' . $partial));

        return json_decode($str);
    }

    private function getComponentScript($component)
    {
        preg_match("#<\s*?script\b[^>]*>(.*?)</script\b[^>]*>#s", $component, $match);
        $javascript = $match[1];

        $parts = explode('{', $javascript);

        array_shift($parts);

        return trim(implode('{', $parts));
    }

    private function getViewSections()
    {
        
        if(!$this->viewSections)
        {
            $view = View::make($this->view);

            $this->viewSections = $view->renderSections();

            $this->detectSlotAvailability($this->viewSections);
        }

        return $this->viewSections;
    }

    private function cleanHtml($html)
    {
        $html = preg_replace(
            array(
                '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s',
                '/ {2,}/',
            ),
            array(
                ' ',
                ' '
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
        if (!isset($sections['template'])) {
            throw new \Exception('Something is wrong with this template: ' . $this->view);
        }

        $this->hasSliceSlot = (strpos($sections['template'], '<slices') !== false || strpos($sections['template'], '@slices') !== false);

        if (!$this->hasSliceSlot)
        {
            $this->hasSliceSlot = ((strpos($sections['component'], 'hasChildSlot: true') !== false) || (strpos($sections['component'], 'hasChildSlot:true') !== false));
        }
    }

    private function getNameFromView()
    {
        $name = str_replace('slices.', '', $this->view);
        $name = str_replace('.', ' ', $name);

        return $this->toHuman($name);
    }

    private function toHuman($string)
    {
        $string = preg_replace("/[^a-zA-Z]/", " ", $string);

        return ucwords($string);
    }

}
