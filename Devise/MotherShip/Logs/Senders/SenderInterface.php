<?php namespace Devise\Mothership\Logs\Senders;

use Devise\Mothership\Logs\Payload\Payload;
use Devise\Mothership\Logs\Payload\EncodedPayload;

interface SenderInterface
{
    public function send(EncodedPayload $payload, $accessToken);
    public function sendBatch($batch, $accessToken);
    public function wait($accessToken, $max);
    public function toString();
}
