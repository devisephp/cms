<?php namespace Devise\Support\Config;

use Mockery as m;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class SettingsManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $structure = array(
            'my' => array(
                'path' => array(
                    'config.overrides.php' => $this->fixture('config-overrides'),
                ),
            ),
        );

        vfsStream::setup('root', null, $structure);
    }

    public function test_it_can_update()
    {
        // given
    	$overridesFile = vfsStream::url('root/my/path/config.overrides.php');
    	$settings = ['b' => 4, 'other.thing' => 'Some value'];

        // when
    	$Framework = new \Devise\Support\Framework;
    	$SettingsManager = new SettingsManager($Framework, $overridesFile);
    	$SettingsManager->update($settings);

        // then
        $results = require $overridesFile;
        assertEquals(["b" => 4, "other.thing" => "Some value"], $results);
    }

    public function test_it_can_merge()
    {
        // given
        $overridesFile = vfsStream::url('root/my/path/config.overrides.php');
        $settings = ['b' => 4, 'other.thing' => 'Some value'];

        // when
        $Framework = new \Devise\Support\Framework;
        $SettingsManager = new SettingsManager($Framework, $overridesFile);
        $SettingsManager->merge($settings);

        // then
        $results = require $overridesFile;
        assertEquals(["a" => 1, "b" => 4, "other.thing" => "Some value"], $results);
    }

}