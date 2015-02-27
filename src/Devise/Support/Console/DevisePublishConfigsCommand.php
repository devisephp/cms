<?php namespace Devise\Support\Console;

use Illuminate\Console\Command;
use Illuminate\Container\Container;

class DevisePublishConfigsCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:configs';

    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles installing devise configs';

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        \File::copyDirectory(__DIR__ . '/../../../config', base_path() . '/config');
    }
}