<?php

namespace Devise\Mothership\Logs\Senders;

use Devise\Mothership\Logs\Response;
use Devise\Mothership\Logs\Payload\Payload;
use Devise\Mothership\Logs\Payload\EncodedPayload;

class AgentSender implements SenderInterface
{
    private $utilities;
    private $agentLog;
    private $agentLogLocation;

    public function __construct($opts)
    {
        $this->agentLogLocation = Devise\Mothership\Logs\Defaults::get()->agentLogLocation();
        $this->utilities = new Utilities();
        if (array_key_exists('agentLogLocation', $opts)) {
            $this->utilities->validateString($opts['agentLogLocation'], 'opts["agentLogLocation"]', null, false);
            $this->agentLogLocation = $opts['agentLogLocation'];
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function send(EncodedPayload $payload, $accessToken)
    {
        if (empty($this->agentLog)) {
            $this->loadAgentFile();
        }
        fwrite($this->agentLog, $payload->encoded() . "\n");

        $data = $payload->data();
        $uuid = $data['data']['uuid'];
        return new Response(0, "Written to agent file", $uuid);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function sendBatch($batch, $accessToken)
    {
        if (empty($this->agentLog)) {
            $this->loadAgentFile();
        }
        foreach ($batch as $payload) {
            fwrite($this->agentLog, $payload->encoded() . "\n");
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function wait($accessToken, $max)
    {
        return;
    }

    private function loadAgentFile()
    {
        $filename = $this->agentLogLocation . '/logs-relay.' . getmypid() . '.' . microtime(true) . '.logs';
        $this->agentLog = fopen($filename, 'a');
    }
    
    public function toString()
    {
        return "agent log: " . $this->agentLogLocation;
    }
}
