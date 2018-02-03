<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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
  public function fields()
  {
    return $this->hasMany('DvsField', 'page_version_id')->where('collection_instance_id', null);
  }

  /**
   *
   */
  public function collectionFields()
  {
    return $this->hasMany('DvsField', 'page_version_id')->whereNotNull('collection_instance_id');
  }

  /**
   *
   */
  public function collectionInstances()
  {
    return $this->hasMany('DvsCollectionInstance', 'page_version_id');
  }
}