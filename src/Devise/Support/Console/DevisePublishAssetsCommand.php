<?php namespace Devise\Support\Console;

use File;
use Illuminate\Container\Container;

class DevisePublishAssetsCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:assets';

    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles installing devise assets';

    /**
     * [__construct description]
     * @param [type] $app
     */
    public function __construct(Container $app)
    {
        parent::__construct();
        $this->app = $app;
        $this->File = File::getFacadeRoot();
        $this->__DIR__ = __DIR__;
        $this->public_path = public_path();
        $this->base_path = base_path();
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $this->copyPublicAssets();
        $this->copyErrorViewsToApplication();
        $this->copyHomepageViewToApplication();
    }

    /**
     * Copies the public assets over to the application
     * @return void
     */
    protected function copyPublicAssets()
    {
        $target = $this->__DIR__ . '/../../../../public';
        $source = $this->public_path . '/packages/devisephp/cms';
        $this->File->copyDirectory($target, $source);
    }

    /**
     * Copies the error pages over to the application
     *
     * @return void
     */
    protected function copyErrorViewsToApplication()
    {
        $target = $this->__DIR__ . '/../../../views/errors';
        $source = $this->base_path . '/resources/views/errors/';
        $this->File->copyDirectory($target, $source);
    }

    /**
     * Copies the homepage view to the application
     * if this file doesn't already exist
     *
     * @return void
     */
    protected function copyHomepageViewToApplication()
    {
        $target = $this->__DIR__ . '/../../../views/installer/index-post-install.blade.php';
        $source = $this->base_path . '/resources/views/homepage.blade.php';

        if (!$this->File->exists($source))
        {
            $this->File->copy($target, $source);
        }
    }
}