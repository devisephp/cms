<?php namespace Devise\Mothership\Logs;

interface ResponseHandlerInterface
{
    public function handleResponse($payload, $response);
}
