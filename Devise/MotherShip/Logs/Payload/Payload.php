<?php namespace Devise\Mothership\Logs\Payload;

use Devise\Mothership\Logs\DataBuilder;
use Devise\Mothership\Logs\Config;
use Devise\Mothership\Logs\Utilities;

class Payload implements \Serializable
{
    private $data;
    private $accessToken;
    private $utilities;

    public function __construct(Data $data, $accessToken)
    {
        $this->utilities = new Utilities();
        $this->setData($data);
        $this->setAccessToken($accessToken);
    }

    /**
     * @return Data
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData(Data $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function serialize()
    {
        $result = array(
            "data" => $this->data,
            "access_token" => $this->accessToken,
        );
        return $this->utilities->serializeForLogs($result);
    }
    
    public function unserialize($serialized)
    {
        throw new \Exception('Not implemented yet.');
    }
}
