<?php namespace Devise\Media\Directories;

use Devise\Support\Framework;

/**
 * Class Manager manages categories. A category is basically
 * a directory inside of the /media folder.
 *
 * @property  Storage
 * @package Devise\Media\Directories
 */
class Manager
{
    protected $CategoryPaths;

    protected $Storage;

    protected static $permittedDirectories = '*';

    /**
     *
     */
    public function __construct(DirectoryPaths $CategoryPaths, Framework $Framework)
    {
        $this->CategoryPaths = $CategoryPaths;

        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
    }

    /**
     *
     */
    public function storeNewCategory($input)
    {
        $category = isset($input['directory']) ? $input['directory'] : null;

        if (isset($input['name'])) {
            $serverPath = $this->dotToServerPath($category);

            if ($this->Storage->exists($serverPath . $input['name'])) {
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
        if (isset($input['directory'])) {
            $serverPath = $this->dotToServerPath($input['directory']);

            return $this->Storage->deleteDirectory($serverPath);
        }

        return false;
    }

    public function dotToServerPath($category)
    {
        $localPath = $this->CategoryPaths->fromDot($category);
        $serverPath = $this->CategoryPaths->serverPath($localPath);

        return $serverPath;
    }

    public static function getPermittedDirectories()
    {
        return self::$permittedDirectories;
    }

    public static function setPermittedDirectories($dir = [])
    {
        if ($dir) {
            self::$permittedDirectories = $dir;
        }
    }

    public static function dirPermitted($dir, $level = 'read')
    {
        $dir = trim($dir, '/');
        $base = config('devise.media.source-directory');
        $permittedList = self::getPermittedDirectories();

        if ($permittedList === '*') {
            return true;
        }

        $permittedList = is_array($permittedList) ? $permittedList : [$permittedList];

        foreach ($permittedList as $permittedDir) {
            $permittedPath = trim($permittedDir, '/');

            if (strpos($dir, $base) === false) {
                $permittedPath = $base . '/' . trim($permittedDir, '/');
            }

            if ($level === 'read') {
                if (
                    strpos($permittedPath, $dir) === 0 ||
                    strpos($dir, $permittedPath) === 0
                ) {
                    return true;
                }
            }
            if ($level === 'write') {
                if (strpos($dir, $permittedPath) === 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
