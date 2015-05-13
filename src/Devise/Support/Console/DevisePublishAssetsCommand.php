<?php namespace Devise\Support\Console;

use Illuminate\Console\Command;
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
     * Run the package migrations.
     */
    public function handle()
    {
        File::copyDirectory(__DIR__ . '/../../../../public', public_path() . '/packages/devisephp/cms');

        $this->copyErrorViewsToApplication();
    }

    /**
     * Copies the error pages over to the application
     *
     * @return void
     */
    protected function copyErrorViewsToApplication()
    {
        $views = base_path() . '/resources/views/errors/';

        if (! File::isDirectory($views)) File::makeDiretory($views, 511, true);

        foreach (File::files(__DIR__ . '/../../../views/errors') as $file)
        {
            $errorfile = $views . basename($file);

            if (! File::exists($errorfile)) File::copy($file, $errorfile);
        }
    }
}