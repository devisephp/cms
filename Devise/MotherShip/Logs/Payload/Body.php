<?php namespace Devise\Mothership\Logs\Payload;

use Devise\Mothership\Logs\Utilities;

class Body implements \Serializable
{
    /**
     * @var ContentInterface
     */
    private $value;
    private $utilities;

    public function __construct(ContentInterface $value)
    {
        $this->utilities = new Utilities();
        $this->setValue($value);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(ContentInterface $value)
    {
        $this->value = $value;
        return $this;
    }

    public function serialize()
    {
        $result = array();
        $result[$this->value->getKey()] = $this->value;
        return $this->utilities->serializeForLogs($result);
    }
    
    public function unserialize($serialized)
    {
        throw new \Exception('Not implemented yet.');
    }
}
