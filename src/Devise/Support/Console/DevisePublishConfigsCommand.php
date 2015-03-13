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
     * Config files that will be emptied
     *
     * @param string
     */
    protected $emptyTargets = ['templates.php','permissions.php'];

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        \File::copyDirectory(__DIR__ . '/../../../config', base_path() . '/config');

        $appDeviseConfigpath = config_path() . '/devise';
        foreach ($this->emptyTargets as $fileName) {
            \File::put($appDeviseConfigpath . '/' . $fileName, "<?php return array();\n// will merge with devise " . $fileName);
        }
    }
}