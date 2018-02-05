<?php

namespace Devise\Models;

use Devise\Fields\LiveFieldValue;
use Illuminate\Database\Eloquent\Model;

class DvsField extends Model
{
  public $dvs_type = 'field';

  protected $softDelete = true;

  protected $table = 'dvs_fields';

  protected $guarded = array();

  protected $_value;

  protected $dates = ['deleted_at'];

  protected $appends = ['values', 'scope'];

  /**
   * Accessor on this model to get value
   * for the latestVersion of this field
   *
   * @return  LiveFieldValue
   */
  public function getValueAttribute()
  {
    $json = $this->json_value ?: '{}';

    return json_decode($json);
  }

  /**
   * Sometimes we've been using values instead of value
   * so this is here for backwards compatability support
   *
   * @return  LiveFieldValue
   */
  public function getValuesAttribute()
  {
    return $this->getValueAttribute();
  }

  /**
   * Let's us know if the scope of this field is global or page
   *
   * @return string
   */
  public function getScopeAttribute()
  {
    return 'field';
  }
}