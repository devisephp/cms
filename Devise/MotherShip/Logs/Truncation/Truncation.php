<?php namespace Devise\Mothership\Logs\Truncation;

use Devise\Mothership\Logs\Payload\EncodedPayload;

class Truncation
{
    const MAX_PAYLOAD_SIZE = 524288; // 512 * 1024
 
    protected static $truncationStrategies = array(
        "Devise\Mothership\Logs\Truncation\FramesStrategy",
        "Devise\Mothership\Logs\Truncation\StringsStrategy"
    );
    
    /**
     *
     */
    public function truncate(EncodedPayload $payload)
    {
        foreach (static::$truncationStrategies as $strategy) {
            $strategy = new $strategy($this);
            
            if (!$strategy->applies($payload)) {
                continue;
            }
            
            if (!$this->needsTruncating($payload, $strategy)) {
                break;
            }
    
            $payload = $strategy->execute($payload);
        }
        
        return $payload;
    }
    
    /**
     *
     */
    public function needsTruncating(EncodedPayload $payload, $strategy)
    {
        return $payload->size() > self::MAX_PAYLOAD_SIZE;
    }
}
