<?php namespace Devise\Mothership\Logs;

interface DataBuilderInterface
{
    public function makeData($level, $toLog, $context);
}
