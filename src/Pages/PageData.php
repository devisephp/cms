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
    $template = self::clean($sections['template']);

    preg_match("#<\s*?script\b[^>]*>(.*?)</script\b[^>]*>#s", $component, $match);
    $javascript = $match[1];

    $parts = explode('{', $javascript);

    array_shift($parts);
    $partial = implode('{', $parts);

    $code = 'Devise' . $slice->name . ": {\ntemplate:\"" . $template . "\"," . $partial;

    Devise::addComponent($code);
  }

  private static function clean($html)
  {
    $html = str_replace(PHP_EOL, '', $html);
    $html = preg_replace('/(\>)\s*(\<)/m', '$1$2', $html);

    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8', true);
  }
}
