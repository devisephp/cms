<?php namespace Devise\Mothership\Logs\Payload;

use Devise\Mothership\Logs\Utilities;

class Trace implements ContentInterface
{
    private $frames;
    private $exception;
    private $utilities;

    public function __construct(array $frames, ExceptionInfo $exception)
    {
        $this->utilities = new Utilities();
        $this->setFrames($frames);
        $this->setException($exception);
    }

    public function getKey()
    {
        return 'trace';
    }

    public function getFrames()
    {
        return $this->frames;
    }

    public function setFrames(array $frames)
    {
        $this->frames = $frames;
        return $this;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException(ExceptionInfo $exception)
    {
        $this->exception = $exception;
        return $this;
    }

    public function serialize()
    {
        $result = array(
            "frames" => $this->frames,
            "exception" => $this->exception,
        );
        return $this->utilities->serializeForLogs($result);
    }
    
    public function unserialize($serialized)
    {
        throw new \Exception('Not implemented yet.');
    }
}
