<?php namespace Devise\Pages;

use Devise\Devise;
use Devise\Http\Resources\PageDataResource;
use Devise\Models\DvsPage;
use Devise\Models\DvsSlice;

use Devise\Models\DvsSliceInstance;
use Illuminate\Support\Facades\View;

class PageData
{

  public static function build(DvsPage $page)
  {
    self::compileVueData($page->version->slices);
  }

  private static function compileVueData($slices)
  {
    foreach ($slices as $child)
    {
      self::extractComponents($child);
      self::compileVueData($child->slices);
    }
  }

  private static function extractComponents(DvsSliceInstance $instance)
  {
    if (View::exists($instance->slice->view))
    {
      Devise::addComponent($instance->slice);
    }
  }

  private static function addComponent(DvsSlice $slice)
  {

  }
}
