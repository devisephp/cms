<?php namespace Devise\Mothership\Logs;

interface FilterInterface
{
    public function shouldSend($payload, $accessToken);
}
