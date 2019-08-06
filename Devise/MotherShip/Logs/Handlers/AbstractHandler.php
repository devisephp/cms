<?php namespace Devise\Mothership\Logs\Handlers;

use Devise\Mothership\Logs\Client;

abstract class AbstractHandler
{
    protected $registered = false;
    
    protected $logger = null;
    
    protected $previousHandler = null;
    
    public function __construct(Client $logger)
    {
        $this->logger = $logger;
    }
    
    public function logger()
    {
        return $this->logger;
    }
    
    public function registered()
    {
        return $this->registered;
    }
    
    public function handle()
    {
        if (!$this->registered()) {
            throw new \Exception(get_class($this) . ' has not been set up.');
        }
    }
    
    public function register()
    {
        $this->registered = true;
    }
}
