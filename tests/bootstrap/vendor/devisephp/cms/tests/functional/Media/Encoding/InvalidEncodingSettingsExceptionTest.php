<?php namespace Devise\Media\Encoding;

use Mockery as m;

class InvalidEncodingSettingsExceptionTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        new InvalidEncodingSettingsException;
    }
}