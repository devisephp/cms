<?php namespace Devise\Pages\Interpreter;

use Mockery as m;
use Closure;

class ExtendedBladeCompilerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->CompilerInterface = m::mock('\Illuminate\View\Compilers\CompilerInterface');
        $this->Filesystem = m::mock('\Illuminate\Filesystem\Filesystem');

        $this->ExtendedBladeCompiler = new \Devise\Pages\Interpreter\ExtendedBladeCompiler($this->CompilerInterface, $this->Filesystem);
    }

    public function test_it_can_get_compiled_path()
    {
        $this->CompilerInterface
            ->shouldReceive('getCompiledPath')
            ->once()
            ->andReturn('/storage/framework/views/94565e973061ec12ebe334cd290fd819');

        $output = $this->ExtendedBladeCompiler->getCompiledPath('/views/some.blade.php');

        assertEquals('/storage/framework/views/94565e973061ec12ebe334cd290fd819', $output);
    }

    public function test_it_can_determine_view_is_expired()
    {
        $this->CompilerInterface
            ->shouldReceive('isExpired')
            ->once()
            ->andReturn(false);

        $output = $this->ExtendedBladeCompiler->isExpired('/views/some.blade.php');

        assertFalse($output);
    }

    public function test_it_can_compile()
    {
        $this->CompilerInterface->afterCompiled = [];

        $this->CompilerInterface
            ->shouldReceive('compile')
            ->once()
            ->andReturn(true)
            ->shouldReceive('getCompiledPath')
            ->once()
            ->andReturn( '/storage/framework/views/58a771468d5c39216b9c8c5e7fe5f5a8' );

        $this->Filesystem
            ->shouldReceive('get')
            ->once()
            ->andReturn( $this->getCompiledViewData() );

        $output = $this->ExtendedBladeCompiler->compile('/views/some.blade.php');

        assertTrue($output);
    }

    public function test_it_can_extend()
    {
        $this->markTestIncomplete();
    }

	public function test_it_can_run_after_compiled_closures()
	{
        $this->CompilerInterface->afterCompiled = [];

        $this->CompilerInterface
            ->shouldReceive('getCompiledPath')
            ->once()
            ->andReturn( '/storage/framework/views/58a771468d5c39216b9c8c5e7fe5f5a8' );

        $this->Filesystem
            ->shouldReceive('get')
            ->once()
            ->andReturn( $this->getCompiledViewData() );

        $output = $this->ExtendedBladeCompiler->runAfterCompiledClosures('/views/some.blade.php');

        assertNull($output);
	}


    /**
     * Used to return compiled view data
     *
     * @return string
     */
    private function getCompiledViewData()
    {
        return '
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title><?= $page->title ?></title>
                    ␉<link href="<?= URL::asset("/packages/devisephp/cms/css/dvs-admin.css") ?>" type="text/css" rel="stylesheet">
                    ␉<link rel="stylesheet" type="text/css" href="<?= URL::asset("/packages/devisephp/cms/css/bootstrap.min.css") ?>">
                    <link href="<?= URL::asset("/packages/devisephp/cms/css/main.css") ?>" rel="stylesheet">
                    <script type="text/javascript" src="<?= URL::asset("/packages/devisephp/cms/js/devise.min.js") ?>"></script>
                </head>

                <body id="dvs-admin">
                  <?php echo $__env->yieldContent("content"); ?>
                </body>
            </html>
        ';
    }

}