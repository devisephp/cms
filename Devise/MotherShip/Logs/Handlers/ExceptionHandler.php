<?php namespace Devise\Mothership\Logs\Handlers;

use Devise\Mothership\LogsDevise\Mothership\Logs;
use Devise\Mothership\LogsDevise\Mothership\LogsLogger;
use Devise\Mothership\Logs\Payload\Level;

class ExceptionHandler extends AbstractHandler
{
    
    public function register()
    {
        $this->previousHandler = set_exception_handler(array($this, 'handle'));
        
        parent::register();
    }
    
    public function handle()
    {
        parent::handle();
        
        /**
         * Overloading methods with different parameters is not supported in PHP
         * through language structures. This hack allows to simulate that.
         */
        $args = func_get_args();
        
        if (!isset($args[0])) {
            throw new \Exception('No exception to be passed to the exception handler.');
        }
        
        $exception = $args[0];
        
        $this->logger()->log(Level::ERROR, $exception, array(), true);
        
        if ($this->previousHandler) {
            restore_exception_handler();
            call_user_func($this->previousHandler, $exception);
            return;
        }


        throw $exception;
    }
}
