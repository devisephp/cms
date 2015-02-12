<?php namespace Devise\Support\Config;

use Mockery as m;

class SettingsManagerTest extends \DeviseTestCase
{
    public function test_it_can_update()
    {
    	$overridesFile = '/the/path/to/config.overrides.php';
    	$settings = [
    		'a' => 1, 'b' => 2, 'other.thing' => 'Some value',
    	];

    	// content needs to look exactly like below,
    	// so don't reformat it or change how it is tabbed
    	$content = "<?php return array (
		'a' => 1,
		'b' => 2,
		'other.thing' => 'Some value',
	);";

    	$Framework = new \Devise\Support\Framework;
    	$Framework->File = m::mock('Illuminate\Filesystem\Filesystem');
    	$Framework->Container = m::mock('Illuminate\Container\Container');
    	$Framework->Container->shouldReceive('make')->with('config.overrides.file')->andReturn($overridesFile);
    	$Framework->File->shouldReceive('put')->with($overridesFile, $content);

    	$SettingsManager = new SettingsManager($Framework);
    	$SettingsManager->update($settings);
    }
}