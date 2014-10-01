<?php namespace Devise\MediaManager\Categories;

use Config;
use Devise\MediaManager\Helpers\CategoryPaths;
use Illuminate\Filesystem\Filesystem;
use Imagick;

class Manager
{
    protected $Filesystem;
    protected $CategoryPaths;

    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
        $this->basepath = public_path() . '/media/';
    }

    public function storeNewCategory($input)
    {
        if(isset($input['name']) && isset($input['category']))
        {
            $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
            $serverPath = $this->CategoryPaths->serverPath($localPath);

            if ($this->Filesystem->isDirectory($serverPath . $input['name']))
            {
                throw new CategoryAlreadyExistsException('This category already exists, cannot create ' . $input['name']);
            }

            return $this->Filesystem->makeDirectory($serverPath . $input['name'], 0775);
        }

        return false;
    }

    public function destroyCategory($input)
    {
        if(isset($input['category'])){
            $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
            $serverPath = $this->CategoryPaths->serverPath($localPath);
            $this->Filesystem->deleteDirectory($serverPath);
        } else {
            return false;
        }
    }

    public function renameCategory($path, $newName)
    {
        $base = $this->basepath . $path;
        rename($base, dirname($base) . '/' . $newName);
    }
}