<?php namespace Devise\Mothership\Logs\Truncation;

use \Devise\Mothership\Logs\Payload\EncodedPayload;

interface IStrategy
{
    /**
     * @param array $payload
     * @return array
     */
    public function execute(EncodedPayload $payload);
    
    /**
     * @param array $payload
     * @return array
     */
    public function applies(EncodedPayload $payload);
}
