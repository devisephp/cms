<?php namespace Devise\Mothership\Logs\Truncation;

use \Devise\Mothership\Logs\Payload\EncodedPayload;

class RawStrategy extends AbstractStrategy
{
    public function execute(EncodedPayload $payload)
    {
        return $payload;
    }
}
