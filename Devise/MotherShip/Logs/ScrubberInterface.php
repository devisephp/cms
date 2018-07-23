<?php namespace Devise\Mothership\Logs;

interface ScrubberInterface
{
    public function scrub(&$data, $replacement);
}
