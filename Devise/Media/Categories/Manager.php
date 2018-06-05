<?php namespace Devise\Media\Categories;

use Devise\Support\Framework;

/**
 * Class Manager manages categories. A category is basically
 * a directory inside of the /media folder.
 *
 * @package Devise\Media\Categories
 */
class Manager
{
  protected $CategoryPaths;

  /**
   *
   */
  public function __construct(CategoryPaths $CategoryPaths, Framework $Framework)
  {
    $this->CategoryPaths = $CategoryPaths;
    $this->Storage = $Framework->storage;
  }

  /**
   *
   */
  public function storeNewCategory($input)
  {
    $category = isset($input['directory']) ? $input['directory'] : null;

    if (isset($input['name']))
    {
      $localPath = $this->CategoryPaths->fromDot($category);
      $serverPath = $this->CategoryPaths->serverPath($localPath);

      if ($this->Storage->exists($serverPath . $input['name']))
      {
        throw new \Exception('This category already exists, cannot create ' . $input['name']);
      }

      return $this->Storage->makeDirectory($serverPath . $input['name']);
    }

    return false;
  }

  /**
   *
   */
  public function destroyCategory($input)
  {
    if (isset($input['directory']))
    {
      $localPath = $this->CategoryPaths->fromDot($input['directory']);
      $serverPath = $this->CategoryPaths->serverPath($localPath);

      return $this->Storage->deleteDirectory($serverPath);
    }

    return false;
  }
}
