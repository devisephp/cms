<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Model;

class DvsField extends Model
{
  protected $table = 'dvs_fields';

  protected $fillable = ['slice_instance_id', 'key'];

  /**
   * Accessor on this model to get value
   * for the latestVersion of this field
   *
   */
  public function getValueAttribute()
  {
    $json = $this->json_value ?: '{}';

    return json_decode($json);
  }
}