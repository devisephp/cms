<?php

namespace Devise\MotherShip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DvsRelease extends Model
{
  use SoftDeletes;

  public $table = 'dvs_releases';

  public $fillable = ['model_id', 'model_name', 'msh_id'];

  public $appends = ['table', 'max_id'];

  public function modelRecord()
  {
    return $this->morphTo('model', 'model_name', 'model_id');
  }

  public function getTopLevelModelAttribute()
  {
    switch ($this->model_name)
    {
      case 'Devise\Models\DvsField':
        return $this->modelRecord->sliceInstance->pageVersion;
        break;
      case 'Devise\Models\DvsSliceInstance':
        return $this->modelRecord->pageVersion;
        break;
      case 'Devise\Models\DvsTemplateSlice':
        return $this->modelRecord->template;
        break;
      default:
        return $this->modelRecord;
        break;
    }
  }

  public function getChangeDescriptionAttribute()
  {
    switch ($this->model_name)
    {
      case 'Devise\Models\DvsField':
        return 'Field Updated';
        break;
      case 'Devise\Models\DvsSliceInstance':
        return 'Slice Updated';
        break;
      case 'Devise\Models\DvsTemplateSlice':
        return 'Template Slice Updated';
        break;
      default:
        return 'Update Made';
        break;
    }
  }

  public function saveCreate($record)
  {
    $this->create([
      'model_id'   => $record->id,
      'model_name' => get_class($record),
      'msh_id'     => 0
    ]);
  }

  public function saveUpdate($record)
  {
    if (count($record->getDirty()) > 0)
    {
      $existing = $this->where('model_id', $record->id)
        ->where('model_name', get_class($record))
        ->first();

      if ($existing)
      {
        $existing->touch();
      } else
      {
        $this->saveCreate($record);
      }
    }
  }

  public function saveDelete($record)
  {
    $existing = $this->where('model_id', $record->id)
      ->where('model_name', get_class($record))
      ->select('msh_id')
      ->first();

    if ($existing)
    {
      if ($existing->msh_id)
      {
        $existing->delete();
      } else
      {
        $existing->forceDelete();
      }
    }
  }

  public function getTableAttribute()
  {
    $model = App::make($this->model_name);

    return $model->getTable();
  }

  public function getMaxIdAttribute()
  {
    return $this->where('model_name', $this->model_name)
      ->orderBy('msh_id', 'desc')
      ->select('msh_id')
      ->first()
      ->msh_id;
  }
}