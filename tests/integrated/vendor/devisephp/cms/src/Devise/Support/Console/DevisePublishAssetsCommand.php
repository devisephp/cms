<?php namespace Devise\Support\Console;

use Illuminate\Console\Command;
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
     * Run the package migrations.
     */
    public function handle()
    {
        \File::copyDirectory(__DIR__ . '/../../../../public', public_path() . '/packages/devisephp/cms');
    }
}