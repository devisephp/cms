<?php
use Mockery as m;
use Devise\Pages\Compilers\TemplateCompiler;
use Devise\Pages\Validators\HtmlValidator;
use Devise\Pages\Compilers\FieldCompiler;
use Devise\Pages\Compilers\FormCompiler;

class TemplateCompilerTest extends Orchestra\Testbench\TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * tests parse()
     * compiler will validate, run the other compilers and should not try to put the files
     * because it's in scan only mode
     */
    public function testParseValidatesScanOnly()
    {
        Config::set('devise::views', array());
        $FileMock = m::mock('FileMock');
        $FileMock->shouldReceive('put')
            ->times(0);

        File::swap($FileMock);

        $FieldMock = m::mock('Field');
        $HtmlVMock = m::mock('Devise\Pages\Validators\HtmlValidator');
        $HtmlVMock->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $FieldCMock = m::mock('Devise\Pages\Compilers\FieldCompiler', array($FieldMock));
        $FieldCMock->shouldReceive('parse')
            ->times(6);

        $FormCMock = m::mock('Devise\Pages\Compilers\FormCompiler');
        $FormCMock->shouldReceive('parse')
            ->times(6);

        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');
        $compiler = new TemplateCompiler($HtmlVMock, $FieldCMock, $FormCMock);
        $result = $compiler->parse($html, true);
        
        $this->assertEquals(3, count($result));
    }

    /**
     * tests parse()
     * compiler will validate, run the other compilers and will try to put the files
     * because it's not in scan only mode
     */
    public function testParseValidatesSavesFiles()
    {
        Config::set('devise::views', array());
        $FileMock = m::mock('FileMock');
        $FileMock->shouldReceive('put')
            ->times(3);

        File::swap($FileMock);

        $FieldMock = m::mock('Field');
        $HtmlVMock = m::mock('Devise\Pages\Validators\HtmlValidator');
        $HtmlVMock->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $FieldCMock = m::mock('Devise\Pages\Compilers\FieldCompiler', array($FieldMock));
        $FieldCMock->shouldReceive('parse')
            ->times(6);

        $FormCMock = m::mock('Devise\Pages\Compilers\FormCompiler');
        $FormCMock->shouldReceive('parse')
            ->times(6);

        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');
        $compiler = new TemplateCompiler($HtmlVMock, $FieldCMock, $FormCMock);
        $result = $compiler->parse($html, false);
        
        $this->assertEquals(3, count($result));
    }

    /**
     * tests parse()
     * compiler fails validation returns false and sets the message
     */
    public function testParseValidationFails()
    {
        Config::set('devise::views', array());
        $FileMock = m::mock('FileMock');

        File::swap($FileMock);

        $FieldMock = m::mock('Field');
        $HtmlVMock = m::mock('Devise\Pages\Validators\HtmlValidator');
        $HtmlVMock->shouldReceive('validate')
            ->once()
            ->andReturn(false);

        $FieldCMock = m::mock('Devise\Pages\Compilers\FieldCompiler', array($FieldMock));

        $FormCMock = m::mock('Devise\Pages\Compilers\FormCompiler');

        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');
        $compiler = new TemplateCompiler($HtmlVMock, $FieldCMock, $FormCMock);
        $result = $compiler->parse($html);
        
        $this->assertFalse($result);
        $this->assertEquals($compiler->message, 'Validation of html failed');
    }

    /**
     * tests parse()
     * compiler will validate. FieldCompiler has warnings and it will get set on templateCompiler
     */
    public function testParseValidatesWithWarnings()
    {
        Config::set('devise::views', array());
        $FileMock = m::mock('FileMock');
        $FileMock->shouldReceive('put')
            ->times(3);

        File::swap($FileMock);

        $FieldMock = m::mock('Field');
        $HtmlVMock = m::mock('Devise\Pages\Validators\HtmlValidator');
        $HtmlVMock->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $FieldCMock = m::mock('Devise\Pages\Compilers\FieldCompiler', array($FieldMock));
        $FieldCMock->shouldReceive('parse')
            ->times(6)
            ->set('warnings', array('warning 1'));

        $FormCMock = m::mock('Devise\Pages\Compilers\FormCompiler');
        $FormCMock->shouldReceive('parse')
            ->times(6);

        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');
        $compiler = new TemplateCompiler($HtmlVMock, $FieldCMock, $FormCMock);
        $result = $compiler->parse($html, false);
        
        $this->assertEquals(6, count($compiler->warnings));
        $this->assertEquals(3, count($result));
    }

    /**
     * tests parse()
     * compiler will validate. Options will be passed and will be passed to the compilers
     */
    public function testParseValidatesWithOptions()
    {
        Config::set('devise::views', array());
        $FileMock = m::mock('FileMock');
        $FileMock->shouldReceive('put')
            ->times(3);

        File::swap($FileMock);

        $FieldMock = m::mock('Field');
        $HtmlVMock = m::mock('Devise\Pages\Validators\HtmlValidator');
        $HtmlVMock->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $FieldCMock = m::mock('Devise\Pages\Compilers\FieldCompiler', array($FieldMock));
        $FieldCMock->shouldReceive('parse')
            ->times(6)
            ->set('warnings', array('warning 1'));

        $FormCMock = m::mock('Devise\Pages\Compilers\FormCompiler');
        $FormCMock->shouldReceive('parse')
            ->times(6);

        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');
        $compiler = new TemplateCompiler($HtmlVMock, $FieldCMock, $FormCMock);
        $result = $compiler->parse($html, false, array(
            'layouts_front_end' => array(
                'fields' => 'test fields',
                'forms' => 'test forms',
            ),
            'pages_child' => array(
                'fields' => 'test fields',
                'forms' => 'test forms',
            ),
            'pages_grandchild' => array(
                'fields' => 'test fields',
                'forms' => 'test forms',
            )
        ));
        
        $this->assertEquals(6, count($compiler->warnings));
        $this->assertEquals(3, count($result));
    }

    /**
     * tests getHtml()
     * testing get html after parsing
     */
    public function testGetHtml()
    {
        Config::set('devise::views', array());
        $FileMock = m::mock('FileMock');
        $FileMock->shouldReceive('put')
            ->times(0);

        File::swap($FileMock);

        $FieldMock = m::mock('Field');
        $HtmlVMock = m::mock('Devise\Pages\Validators\HtmlValidator');
        $HtmlVMock->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $FieldCMock = m::mock('Devise\Pages\Compilers\FieldCompiler', array($FieldMock));
        $FieldCMock->shouldReceive('parse')
            ->times(6)
            ->set('warnings', array('warning 1'));

        $FormCMock = m::mock('Devise\Pages\Compilers\FormCompiler');
        $FormCMock->shouldReceive('parse')
            ->times(6);

        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');
        $compiler = new TemplateCompiler($HtmlVMock, $FieldCMock, $FormCMock);
        $compiler->parse($html, true);
        
        $result = $compiler->getHtml();
        $this->assertEquals($result, $html);
    }
}