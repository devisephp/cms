<?php


namespace Devise\Media\Files;

use DvsMediaManager;
use Illuminate\Support\Facades\Log;

class MediaFieldObserver
{
  /**
   * @var Repository
   */
  private $repository;

  /**
   * MediaFieldObserver constructor.
   */
  public function __construct(Repository $repository)
  {
    $this->repository = $repository;
  }

  public function saved($model)
  {
    $this->updateMediaManager($model);
  }

  public function deleted($model)
  {
    $this->updateMediaManager($model);
  }

  private function updateMediaManager($model)
  {
    if ($model->type == 'image' || $model->type == 'file')
    {
      list($path, $fileName) = $this->getNameAndPath($model);

      $record = DvsMediaManager::where('directory', $path)
        ->where('name', $fileName)
        ->first();
      if(!$record){

        Log::info($model->id . '    ' . $path . '    ' . $fileName);
      }
      if ($record && $record->getDirty())
      {
        if ($this->isGlobal($model))
        {
          $record->global_fields = json_encode($this->repository->getGlobalDataForFile($fileName));
        } else
        {
          $record->fields = json_encode($this->repository->getFieldDataForFile($fileName));
        }

        $record->save();
      }
    }
  }

  private function getNameAndPath($model)
  {
    $val = json_decode($model->json_value);

    if (isset($val->image)) {
      $imagePath = $val->image;
      $parts = explode('/', $imagePath);
      $fileName = array_pop($parts);
      array_shift($parts);
      $path = implode("/", $parts);

      return [$path, $fileName];
    }
    return ['', ''];
  }

  private function isGlobal($model)
  {
    return (strpos(get_class($model), 'DvsGlobalField') !== false);
  }
}
