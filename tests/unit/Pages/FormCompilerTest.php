<?php

use Devise\Pages\Compilers\FormCompiler;
use Mockery as m;

class FormompilerTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests parse()
     * testing a form html is not changed when scanOnly is true
     */
    public function testParseImageScanOnly()
    {
        $html = $this->getFormOne();

        $dom = HTML5::loadHTML($html);

        $compiler = new FormCompiler($FieldMock);
        $compiler->parse($dom, true);

        $this->assertEquals(1, count($compiler->forms));
        $this->assertEquals('Car', $compiler->forms[0]['model']);
        $this->assertEquals('car_form', $compiler->forms[0]['key']);
        $this->assertContains('data-devise', $dom->saveHtml());
    }

    /**
     * tests parse()
     * testing a form html is changed when scanOnly is false
     */
    public function testParseImageScanOnlyFalse()
    {
        $html = $this->getFormOne();

        $dom = HTML5::loadHTML($html);

        $compiler = new FormCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->forms));
        $this->assertEquals('Car', $compiler->forms[0]['model']);
        $this->assertEquals('car_form', $compiler->forms[0]['key']);

        // testing that blade code exists
        $newHtml = $dom->saveHtml();
        $this->assertContains('Form::model($car', $newHtml);
    }

    /**
     * tests parse()
     * testing all field types will be parsed
     */
    public function testAllFieldTypes()
    {
        $html = $this->getFormTwo();

        $dom = HTML5::loadHTML($html);

        $compiler = new FormCompiler($FieldMock);
        $compiler->parse($dom, false);

        $this->assertEquals(1, count($compiler->forms));
        $this->assertEquals('Car', $compiler->forms[0]['model']);
        $this->assertEquals('car_form', $compiler->forms[0]['key']);

        // testing that blade code exists
        $newHtml = $dom->saveHtml();
        $this->assertContains('Form::model($car', $newHtml);
        $this->assertContains('{{ Form::text(\'texfield\'', $newHtml);
        $this->assertContains('{{ Form::radio(\'radiostuff\'', $newHtml);
        $this->assertContains('{{ Form::hidden(\'hideme\'', $newHtml);
        $this->assertContains('{{ Form::textarea(\'thetext\'', $newHtml);
        $this->assertContains('{{ Form::textarea(\'thetext\'', $newHtml);
        $this->assertContains('{{ Form::select(\'nice-select\'', $newHtml);
        $this->assertContains('{{ Form::submit(\'yeah it is!\'', $newHtml);
    }

    /**
     * tests parse()
     * testing passing of options will change results
     */
    public function testOptions()
    {
        $html = $this->getFormOne();

        $dom = HTML5::loadHTML($html);

        $compiler = new FormCompiler($FieldMock);
        $compiler->parse($dom, false, array(
            'car_form' => array(
                'type' => 'open',
                'model' => 'Factory',
                'key' => 'factory_form',
                'inputs' => array(
                    'texfield' => 'Model.prop'
                )
            )
        ));

        $this->assertEquals(1, count($compiler->forms));
        $this->assertEquals('Factory', $compiler->forms[0]['model']);
        $this->assertEquals('factory_form', $compiler->forms[0]['key']);

        // testing that blade code exists
        $newHtml = $dom->saveHtml();
        $this->assertContains('Form::text(\'Model.prop\'', $newHtml);
    }

    /**
     * tests parse()
     * any unkown input types will throw errors
     */
    public function testUnknownInput()
    {
        $html = $this->getFormThree();

        $dom = HTML5::loadHTML($html);

        $compiler = new FormCompiler($FieldMock);

        $msg = 'should overwrite';

        try{
            $compiler->parse($dom, false);
        } catch(\Exception $e){
            $msg = $e->getMessage();
        }

        $this->assertEquals($msg, 'Unable to parse input with name findme');
    }

    private function getFormOne()
    {
        return '
            <form data-devise="Car Form|Car|model">
                <input name="texfield" type="text" value="face" class="field" />
                <input type="submit" value="yeah it is!" />
            </form>';
    }

    private function getFormTwo()
    {
        return '
            <form data-devise="Car Form|Car|model">
                <input name="texfield" type="text" value="face" class="yes it is" />
                <input name="radiostuff" type="radio" value="1" />
                <input name="hideme" type="hidden" class="awesome" />
                <input name="checkbox" type="checkbox" />

                <textarea name="thetext" rows="20" cols="80">
                   First line of initial text.
                   Second line of initial text.
                </textarea>

                <select multiple size="4" name="nice-select">
                  <option selected value="Component_1_a">Component_1</option>
                  <option value="Component_1_b">Component_2</option>
                  <option>Component_3</option>
                  <option>Component_4</option>
                  <option>Component_5</option>
                  <option>Component_6</option>
                  <option>Component_7</option>
               </select>

                <input type="submit" value="yeah it is!" />
            </form>';
    }

    private function getFormThree()
    {
        return '
            <form data-devise="Car Form|Car|model">
                <input name="findme" type="notReal" value="face" class="field" />
                <input type="submit" value="yeah it is!" />
            </form>';
    }

    private function checkDomValue($dom, $expected)
    {
        $dom->removeChild($dom->firstChild);
        $sectionNode = $dom->firstChild->firstChild;
        $newHtml = $dom->saveHtml($sectionNode);
        $this->assertEquals($expected, $newHtml);
    }
}