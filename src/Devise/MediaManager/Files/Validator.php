<?php namespace Devise\MediaManager\Files;

use Illuminate\Filesystem\Filesystem;

class Validator
{
    protected $Filesystem;

    public function __construct(Filesystem $Filesystem)
    {
        $this->Filesystem = $Filesystem;
    }

    /**
    * Validates that all necessary conditions are met for the media manager to be fully capable
    * @return array();
    * @todo make it work
    **/
    public function checkCapabilities($config)
    {
        if(!$this->Filesystem->exists( public_path().'/'.$config['root-dir'] ))
        {
            $this->Filesystem->makeDirectory(public_path().'/'.$config['root-dir'], 0775);
        }
        return ['capable' => true];
    }
}