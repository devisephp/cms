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
   * Page versions belong to a page
   *
   */
  public function page()
  {
    return $this->belongsTo(DvsPage::class, 'page_id');
  }

  /**
   * Page version has many fields
   *
   */
  public function fields()
  {
    return $this->hasMany('DvsField', 'page_version_id')->where('collection_instance_id', null);
  }

  /**
   * Page version has many collection fields
   */
  public function collectionFields()
  {
    return $this->hasMany('DvsField', 'page_version_id')->whereNotNull('collection_instance_id');
  }

  /**
   * Page version has many collection instances
   */
  public function collectionInstances()
  {
    return $this->hasMany('DvsCollectionInstance', 'page_version_id');
  }
}