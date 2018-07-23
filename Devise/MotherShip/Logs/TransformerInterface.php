<?php namespace Devise\Mothership\Logs;

use Devise\Mothership\Logs\Payload\Level;
use Devise\Mothership\Logs\Payload\Payload;

interface TransformerInterface
{
    /**
     * @param Payload $payload
     * @param Level $level
     * @param \Exception | \Throwable $toLog
     * @param $context
     * @return Payload
     */
    public function transform(Payload $payload, $level, $toLog, $context);
}
