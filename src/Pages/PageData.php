<?php namespace Devise\Pages;

use Devise\Devise;
use Devise\Resources\PageDataResource;
use Devise\Models\DvsPage;
use Devise\Models\DvsSlice;

use Illuminate\Support\Facades\View;

class PageData
{

  public static function build(DvsPage $page)
  {
    self::compileVueData($page->version->template);
  }

  private static function compileVueData($slice)
  {
    if ($slice->view)
    {
      self::extractComponents($slice);
    }

    foreach ($slice->slices as $child)
    {
      self::compileVueData($child->slice);
    }
  }

  private static function extractComponents(DvsSlice $slice)
  {
    if (View::exists($slice->view))
    {
      self::addComponent($slice);
    }
  }

  private static function addComponent($slice)
  {
    $view = View::make($slice->view);

    $sections = $view->renderSections();

    $component = $sections['component'];
    $template = self::cleanHtml($sections['template']);

    preg_match("#<\s*?script\b[^>]*>(.*?)</script\b[^>]*>#s", $component, $match);
    $javascript = $match[1];

    $parts = explode('{', $javascript);

    array_shift($parts);
    $partial = trim(implode('{', $parts));

    $name = $slice->component_name;

    $code = $name . ": {name:\"" . $name . "\",template:\"" . $template . "\"," . $partial;

    Devise::addComponent($name, $code);
  }

  private static function cleanHtml($html)
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
}
