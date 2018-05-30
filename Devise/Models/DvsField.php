<?php

namespace Devise\Models;

class DvsField extends Model
{
  protected $table = 'dvs_fields';

  protected $fillable = ['slice_instance_id', 'key', 'json_value', 'content_requested'];

  public function sliceInstance()
  {
    return $this->belongsTo(DvsSliceInstance::class, 'slice_instance_id');
  }

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