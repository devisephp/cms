<?php

namespace Devise\Models;

use Devise\Devise;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

class DvsPageVersion extends Model
{
  use SoftDeletes;

  protected $softDelete = true;

  protected $table = 'dvs_page_versions';

  protected $guarded = array();

  /**
   * Accessor on this model to get value
   * for the latestVersion of this field
   *
   * @return  FieldValue
   */
  public function getValuesAttribute()
  {
    return json_decode($this->value);
  }

  /**
   *
   */
  public function page()
  {
    return $this->belongsTo(DvsPage::class, 'page_id');
  }

  /**
   *
   */
  public function template()
  {
    return $this->belongsTo(DvsTemplate::class, 'template_id');
  }

  /**
   *
   */
  public function slices()
  {
    return $this->hasMany(DvsSliceInstance::class, 'page_version_id')
      ->where('parent_instance_id', 0);
  }

  public function registerComponents()
  {
    $this->findComponents($this->slices);
  }

  private function findComponents($slices)
  {
    foreach ($slices as $child)
    {
      $this->extractComponents($child);
      $this->findComponents($child->slices);
    }
  }

  private function extractComponents(DvsSliceInstance $instance)
  {
    if (View::exists($instance->slice->view))
    {
      Devise::addComponent($instance->slice);
    }
  }
}