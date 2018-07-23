<?php namespace Devise\Mothership\Logs\Truncation;

use \Devise\Mothership\Logs\Payload\EncodedPayload;

class AbstractStrategy implements IStrategy
{
    protected $truncation;
    
    public function __construct($truncation)
    {
        $this->truncation = $truncation;
    }
    
    public function execute(EncodedPayload $payload)
    {
        return $payload;
    }
    
    public function applies(EncodedPayload $payload)
    {
        return true;
    }
}
