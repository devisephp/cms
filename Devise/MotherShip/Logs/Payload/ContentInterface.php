<?php namespace Devise\Mothership\Logs\Payload;

interface ContentInterface extends \Serializable
{
    public function getKey();
}
