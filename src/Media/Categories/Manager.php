<?php namespace Devise\Media\Categories;

use Devise\Media\Files\Filesystem;

/**
 * Class Manager manages categories. A category is basically
 * a directory inside of the /media folder.
 *
 * @package Devise\Media\Categories
 */
class Manager
{
    /**
     * @var Filesystem
     */
    protected $Filesystem;

    /**
     * @var CategoryPaths
     */
    protected $CategoryPaths;

    /**
     * Create a new category manager
     *
     * @param Filesystem $Filesystem
     * @param CategoryPaths $CategoryPaths
     */
    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
        $this->basepath = public_path() . '/media/';
    }

    /**
     * Stores the category in the filesystem
     *
     * @param $input
     * @return bool
     * @throws CategoryAlreadyExistsException
     */
    public function storeNewCategory($input)
    {
        $category = isset($input['category']) ? $input['category'] : null;
        
        if(isset($input['name']))
        {
            $localPath = $this->CategoryPaths->fromDot($category);
            $serverPath = $this->CategoryPaths->serverPath($localPath);

            if ($this->Filesystem->isDirectory($serverPath . $input['name']))
            {
                throw new CategoryAlreadyExistsException('This category already exists, cannot create ' . $input['name']);
            }

            return $this->Filesystem->makeDirectory($serverPath . $input['name'], 0775);
        }

        return false;
    }

    /**
     * Removes the category path
     *
     * @param $input
     * @return bool
     */
    public function destroyCategory($input)
    {
        if (isset($input['category']))
        {
            $localPath = $this->CategoryPaths->fromDot($input['category']);
            $serverPath = $this->CategoryPaths->serverPath($localPath);
            return $this->Filesystem->deleteDirectory($serverPath);
        }

        return false;
    }

    /**
     * Renames a category path
     *
     * @param $path
     * @param $newName
     */
    public function renameCategory($path, $newName)
    {
        $base = $this->basepath . $path;
        $this->Filesystem->move($base, dirname($base) . '/' . $newName);
    }
}
