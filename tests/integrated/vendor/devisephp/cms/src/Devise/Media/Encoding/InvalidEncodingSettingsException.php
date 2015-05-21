<?php namespace Devise\Media\Encoding;

/**
 * Class InvalidEncodingSettingsException is thrown in ZencoderJob
 * anytime invalid settings are passed in when trying to create a
 * new Zencoder api call to start encoding videos
 *
 * @package Devise\Media\Encoding
 */
class InvalidEncodingSettingsException extends \Devise\Support\DeviseException
{
}