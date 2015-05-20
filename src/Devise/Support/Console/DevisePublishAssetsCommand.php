<?php namespace Devise\Support\Console;

use Devise\Support\IO\FileDiff;
use Illuminate\Container\Container;
use File;

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
     * Input/output for this command
     *
     * @var Command
     */
    public $io;

    /**
     * [__construct description]
     * @param [type] $app
     */
    public function __construct(Container $app)
    {
        parent::__construct();
        $this->app = $app;
        $this->FileDiff = new FileDiff;
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
    }

    /**
     * Copies the public assets over to the application
     * @return void
     */
    protected function copyPublicAssets()
    {
        $target = $this->__DIR__ . '/../../../../public';
        $source = $this->public_path . '/packages/devisephp/cms';
        $difference = $this->FileDiff->different($target, $source);
        $difference = $this->askAboutDifferences($difference);
        $unmodified = $this->FileDiff->unmodified($target, $source);
        $files = array_merge($unmodified, $difference);
        $this->copyFiles($files, $target, $source);
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
        $difference = $this->FileDiff->different($target, $source);
        $difference = $this->askAboutDifferences($difference);
        $unmodified = $this->FileDiff->unmodified($target, $source);
        $files = array_merge($unmodified, $difference);
        $this->copyFiles($files, $target, $source);
    }

    /**
     * Get list of differences
     *
     * @param  [type] $difference
     * @return [type]
     */
    protected function askAboutDifferences($difference)
    {
        $overrides = [];

        foreach ($difference as $file)
        {
            $override = $this->io()->ask("Do you want to override $file [y/N]");
            if (strtoupper($override) === 'Y') $overrides[] = $file;
        }

        return $overrides;
    }

    /**
     * Copies all these files from target to source
     *
     * @param  [type] $files
     * @param  [type] $target
     * @param  [type] $source
     * @return [type]
     */
    protected function copyFiles($files, $target, $source)
    {
        foreach ($files as $file)
        {
            $targetFile = $target . '/' . $file;
            $sourceFile = $source . '/' . $file;
            $sourceDir = dirname($sourceFile);

            if (! $this->File->isDirectory($sourceDir)) $this->File->makeDirectory($sourceDir, 511, true);
            $this->File->copy($targetFile, $sourceFile, true);
        }
    }

    /**
     * Makes an io connection
     *
     * @return [type]
     */
    protected function io()
    {
        return $this->io ?: $this->io = $this;
    }
}