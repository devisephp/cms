<?php namespace Devise\Models\Scaffolding;

use Mockery as m;

class SanityChecksHelperTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $Framework = new \Devise\Support\Framework;
        $this->MockSanityChecksScaffolding = m::mock('Devise\Models\Scaffolding\SanityChecksHelper[checkViewsDirectory, checkSrcDirectory]', [$Framework]);

        $this->constants = [
			'original'        => "little Widget",
			'singular'        => "little widget",
			'singularCase'    => "Little Widget",
			'plural'          => "little widgets",
			'pluralCase'      => "Little Widgets",
			'snakeCase'       => "little_widget",
			'snakeCasePlural' => "little_widgets",
			'camelCase'       => "littleWidget",
			'camelCasePlural' => "littleWidgets",
			'viewsDirectory'  => "little_widgets",
			'srcDirectory'    => "LittleWidgets",
			'modelName'       => "LittleWidget",
			'className'       => "LittleWidgets",
			'slug'            => "little-widgets",
			'singularVar'     => "littleWidget",
			'pluralVar'       => "littleWidgets"
		];
    }

    public function test_sanity_check_passes()
    {
    	$this->MockSanityChecksScaffolding->shouldReceive('checkViewsDirectory')->times(1)->andReturn(true);

    	$this->MockSanityChecksScaffolding->shouldReceive('checkSrcDirectory')->times(1)->andReturn(true);

       	$result = $this->MockSanityChecksScaffolding->runSanityCheck($this->constants, [], []);
        assertTrue($result);
    }

    public function test_sanity_check_fails_when_view_directory_fails()
    {
    	$this->MockSanityChecksScaffolding->shouldReceive('checkViewsDirectory')->times(1)->andReturn(false);

    	$this->MockSanityChecksScaffolding->shouldReceive('checkSrcDirectory')->times(1)->andReturn(true);

       	$result = $this->MockSanityChecksScaffolding->runSanityCheck($this->constants, [], []);
        assertFalse($result);
    }

    public function test_sanity_check_fails_when_src_directory_fails()
    {
    	$this->MockSanityChecksScaffolding->shouldReceive('checkViewsDirectory')->times(1)->andReturn(true);

    	$this->MockSanityChecksScaffolding->shouldReceive('checkSrcDirectory')->times(1)->andReturn(false);

       	$result = $this->MockSanityChecksScaffolding->runSanityCheck($this->constants, [], []);
        assertFalse($result);
    }

}