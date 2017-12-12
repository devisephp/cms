<?php


namespace Devise\Media\Files;

use DvsMediaManager;

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
        ->firstOrFail();

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

  private function getNameAndPath($model)
  {
    $val = json_decode($model->json_value);
    $imagePath = $val->image;
    $parts = explode('/', $imagePath);
    $fileName = array_pop($parts);
    array_shift($parts);
    $path = implode($parts);

    return [$path, $fileName];
  }

  private function isGlobal($model)
  {
    return (strpos(get_class($model), 'DvsGlobalField') !== false);
  }
}