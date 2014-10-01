<?php

use Devise\Pages\Compilers\FieldCompiler;
use Mockery as m;

class FieldCompilerTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests parse()
     * testing an image tag being passed with 3 parameters
     * because scanOnly is true the image tag will not be changed
     */
    public function testParseImage()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<img data-devise="This is the Name|image|data-whatever" src="test" />';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, true);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals('This is the Name', $compiler->fields[0]['human_name']);
        $this->assertEquals('this_is_the_name', $compiler->fields[0]['key']);
        $this->assertEquals('test', $compiler->fields[0]['value']);
        $this->checkDomValue($dom, '<img src="test">');
    }

    /**
     * tests parse()
     * testing an image tag being passed with 3 parameters
     * because scanOnly is false the image tag will be changed
     */
    public function testParseImageScanFalse()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<img data-devise="This is the Name|image|data-whatever" src="test" />';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals('This is the Name', $compiler->fields[0]['human_name']);
        $this->assertEquals('this_is_the_name', $compiler->fields[0]['key']);
        $this->assertEquals('test', $compiler->fields[0]['value']);
        $this->checkDomValue($dom, '<img src="%7B%7B%20%24page-&gt;this_is_the_name%20%7D%7D">'); // will be cleaned by template compiler
    }

    /**
     * tests parse()
     * testing an image tag being passed with 3 parameters
     * because scanOnly is false the image tag will be changed
     */
    public function testParseDivUseContent()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<div data-devise="This is the editor|editor">this is the value</div>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals('This is the editor', $compiler->fields[0]['human_name']);
        $this->assertEquals('this_is_the_editor', $compiler->fields[0]['key']);
        $this->assertEquals('this is the value', $compiler->fields[0]['value']);
        $this->checkDomValue($dom, '<div>{{ $page-&gt;this_is_the_editor }}</div>'); // will be cleaned by template compiler
    }

    /**
     * tests parse()
     * testing group option and json object in attribute works
     */
    public function testGroupOptionsJsonObject()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<div data-devise="This is the rock|image|data-face:dude|group:boss" style="background-image:whatever.jpg" class="whatever">This is the random div</div>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals('This is the rock', $compiler->fields[0]['human_name']);
        $this->assertEquals('this_is_the_rock', $compiler->fields[0]['key']);
        $this->assertEquals('', $compiler->fields[0]['value']);
        $this->checkDomValue($dom, '<div style="background-image:whatever.jpg" class="whatever dvs-group-boss" data-face="{\'dude\':\'{{ $page-&gt;this_is_the_rock }}\'}">This is the random div</div>'); // will be cleaned by template compiler
    }

    /**
     * tests parse()
     * testing route option does not get added to fields
     */
    public function testRoute()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<a data-devise="route_name_face|route|href" style="font-weight:bold">Blammo</a>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(0, count($compiler->fields));
        $this->checkDomValue($dom, '<a style="font-weight:bold" href="%7B%7B%20URL::route(\'route_name_face\')%20%7D%7D">Blammo</a>'); // will be cleaned by template compiler
    }

    /**
     * tests parse()
     * testing style options changes inline style
     */
    public function testStyleOption()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<a data-devise="Test Name|image|style:background-image">Blammo</a>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals('Test Name', $compiler->fields[0]['human_name']);
        $this->assertEquals('test_name', $compiler->fields[0]['key']);
        $this->assertEquals('', $compiler->fields[0]['value']);
        $this->checkDomValue($dom, '<a style="background-image:{{ $page-&gt;test_name }}">Blammo</a>'); // will be cleaned by template compiler
    }

    /**
     * tests parse()
     * testing existing page field returns id and level == 0
     */
    public function testExistingPageField()
    {
        $FieldMock = m::mock('Field');
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('getAttribute')
            ->andReturn(123)
            ->shouldReceive('first')
            ->andReturn(m::self());

        $html = '<img data-devise="Test Name|image">Blammo</img>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals(123, $compiler->fields[0]['id']);
        $this->assertEquals(0, $compiler->fields[0]['level']);
    }

    /**
     * tests parse()
     * testing existing global field returns id and level == 1
     */
    public function testingExistingGlobalField()
    {
        $FieldMock = m::mock('Field')->makePartial();
        $FieldMock->id = 321;
        $FieldMock->template = false;
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(m::self());

        $html = '<img data-devise="Test Name|image">Blammo</img>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals(321, $compiler->fields[0]['id']);
        $this->assertEquals(1, $compiler->fields[0]['level']);
    }

    /**
     * tests parse()
     * testing existing overite options will change level
     */
    public function testingOverwriteOptions()
    {
        $FieldMock = m::mock('Field')->makePartial();
        $FieldMock->id = 678;
        $FieldMock->template = false;
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(m::self());

        $html = '<img data-devise="Test Name|image">Blammo</img>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->parse($dom, false, array(
            array(
                'key' => 'test_name',
                'overwrite' => true,
                'level' => 444
            )
        ));

        $this->assertEquals(1, count($compiler->fields));
        $this->assertEquals(678, $compiler->fields[0]['id']);
        $this->assertEquals(444, $compiler->fields[0]['level']);
    }

    /**
     * tests parse()
     * testing duplicate name will have warnings
     */
    public function testWarnings()
    {
        $FieldMock = m::mock('Field')->makePartial();
        $FieldMock->shouldReceive('whereIn')
            ->andReturn(m::self())
            ->shouldReceive('whereKey')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturn(false);

        $html = '<img data-devise="Test Name|image">Blammo</img><img data-devise="Test Name|image">Blammo</img>';
        $dom = HTML5::loadHTML($html);

        $compiler = new FieldCompiler($FieldMock);
        $compiler->templatePath = 'test.template';
        $compiler->parse($dom, true);

        $this->assertEquals($compiler->warnings[0], '"Test Name" field in "test.template" multiple times. The options of the first occurrence will be used. Please double check your settings bellow before saving.');
    }


    private function checkDomValue($dom, $expected)
    {
        $dom->removeChild($dom->firstChild);
        $sectionNode = $dom->firstChild->firstChild;
        $newHtml = $dom->saveHtml($sectionNode);
        $this->assertEquals($expected, $newHtml);
    }
}