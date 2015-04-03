<?php namespace Devise\Sidebar;

/**
 * Class SnippetBladeCompiler converts
 *
 * some blade code such as @snippet <div> some stuff here <?= yep ?> </div> @endsnippet
 * into some code that runs and also some code that is shown. it is easier to
 * do it this way... so we don't have to retype everything twice and with
 * escaped html entities
 *
 * @package Devise\Sidebar
 */
class SnippetBladeCompiler
{

    /**
     * Runs the compile on this view
     *
     * @param $view
     * @return mixed
     */
    public function compile($view)
    {

        $replacements = [];

        $pattern = '/@snippet(.+?)@endsnippet/s';

        preg_match_all($pattern, $view, $matches);

        // loop through all the pattern matches
        foreach ($matches[0] as $index => $match)
        {
            $replacements[$match] = $matches[1][$index];
        }

        // loop through all the replacements
        foreach ($replacements as $replace => $with)
        {
            // $original = $with;
            $with = htmlentities($with);

    // $with = $this->compileSnippetVar($with);


            $with = str_replace('@', '&#64;', $with);
            $with = str_replace('{', '&#123;', $with);
            $with = str_replace('}', '&#125;', $with);
            $with = str_replace(' data-devise=', ' data&#45;devise=', $with);

            // $view = str_replace($replace, "{$original} <pre><code class=\"html\">{$with}</code></pre>", $view);
            // $view = str_replace($replace, "<pre><code class=\"html\">{$with}</code></pre>", $view);

        // $view = $with;
            $view = "<pre><code>{$with}</code></pre>";

        }

        return $view;
    }

    private function compileSnippetVar($with)
    {
        $replacement = '<span class="dvs-live-code" data-devise-doc-target="$1" data-devise-doc-default="$2">';

        return preg_replace('/@snippetvar\(\'(.*)|(.*)\'\)/', $replacement, $with);
    }

}