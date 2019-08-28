<?php namespace Devise\Mothership\Logs\Payload;

use Devise\Mothership\Logs\Utilities;

class Notifier implements \Serializable
{
    const NAME = "devise-logs";
    const VERSION = "0.1";

    public static function defaultNotifier()
    {
        return new Notifier(self::NAME, self::VERSION);
    }

    private $name;
    private $version;
    private $utilities;

    public function __construct($name, $version)
    {
        $this->utilities = new Utilities();
        $this->setName($name);
        $this->setVersion($version);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function serialize()
    {
        $result = array(
            "name"    => $this->name,
            "version" => $this->version,
        );

        return $this->utilities->serializeForLogs($result);
    }

    public function unserialize($serialized)
    {
        throw new \Exception('Not implemented yet.');
    }
}
