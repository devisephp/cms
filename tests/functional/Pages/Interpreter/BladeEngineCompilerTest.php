<?php namespace Devise\Pages\Interpreter;

use Mockery as m;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class BladeEngineCompilerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

        $structure = array(
            'some/path/here' => $this->fixture('devise-views.interpret2'),
        );

        vfsStream::setup('root', null, $structure);

		$this->Compiler = m::mock('Illuminate\View\Compilers\CompilerInterface');
		$this->DeviseCompiler = m::mock('Devise\Pages\Interpreter\DeviseCompiler');
		$this->DeviseParser = m::mock('Devise\Pages\Interpreter\DeviseParser');
		$this->BladeEngineCompiler = new BladeEngineCompiler($this->Compiler, $this->DeviseCompiler, $this->DeviseParser);
	}

	public function test_it_gets_compiled_path()
	{
		$this->Compiler->shouldReceive('getCompiledPath')->with('some/path/here')->once()->andReturnSelf();
		$this->BladeEngineCompiler->getCompiledPath('some/path/here');
	}

	public function test_it_can_tell_us_if_path_is_expired()
	{
		$this->Compiler->shouldReceive('isExpired')->with('some/path/here')->once()->andReturnSelf();
		$this->BladeEngineCompiler->isExpired('some/path/here');
	}

	public function test_it_can_compile_path()
	{
		$path = vfsStream::url('root/some/path/here');
		$code = file_get_contents($path);
		$this->Compiler->shouldReceive('compile')->with($path)->once()->andReturn(null);
		$this->Compiler->shouldReceive('getCompiledPath')->with($path)->once()->andReturn($path);
		$this->DeviseCompiler->shouldReceive('compile')->with($code)->once()->andReturn('it has been compiled!');
		$this->DeviseParser->shouldReceive('hasDeviseTags')->with($code)->once()->andReturn(true);
		$this->BladeEngineCompiler->compile($path);
		$outcome = file_get_contents($path);
		assertEquals('it has been compiled!', $outcome);
	}

	public function test_it_can_extend_blade_with_closures()
	{
		$closure = function() {};
		$this->Compiler->shouldReceive('extend')->with($closure)->once()->andReturnSelf();
		$this->BladeEngineCompiler->extend($closure);
	}

	public function test_it_proxies_method_calls_to_decorated_compiler()
	{
		$this->Compiler->shouldReceive('durkaMethod')->with('some arg')->once()->andReturnSelf();
		$this->BladeEngineCompiler->durkaMethod('some arg');
	}
}