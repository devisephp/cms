<?php
use Mockery as m;

class FieldTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests pages()
     * tests morphedByMany is called on its self
     */
    public function testPages()
    {
        $Field = m::mock('Field')->makePartial();
        $Field->shouldReceive('morphedByMany')
            ->once()
            ->withArgs(array('Page', 'fieldable'))
            ->andReturn(m::self());

        $result = $Field->pages();

        $this->assertEquals($result, $Field);
    }

    /**
     * tests scopeKeyIs()
     * tests whereKey is called on query, keytest is passed, and builder is returned
     */
    public function testScopeKeyIs()
    {
        $Builder = m::mock('Builder');
        $Builder->shouldReceive('whereKey')
            ->once()
            ->with('keytest')
            ->andReturn(m::self());

        $Field = new Field();
        $result = $Field->scopeKeyIs($Builder, 'keytest');

        $this->assertEquals($result, $Builder);
    }

    /**
     * tests getValueAttribute()
     * Field should get the value from pivot if exists
     * if the value is json the value will be decoded and returned as an object or array
     */
    public function testGetValueAttributeWithPivotAndJSON()
    {
        $json = '{"key":"value"}';
        $Field = new Field();
        $Field->pivot = (object) array('value' => $json);
        $result = $Field->getValueAttribute();

        $this->assertEquals('key', key($result));
        $this->assertEquals('value', reset($result));
    }

    /**
     * tests getValueAttribute()
     * Field should get the value from pivot if exists
     * if the value is a string the string is returned
     */
    public function testGetValueAttributeWithPivotAndString()
    {
        $string = 'i am a string';
        $Field = new Field();
        $Field->pivot = (object) array('value' => $string);
        $result = $Field->getValueAttribute();

        $this->assertEquals($string, $result);
    }

    /**
     * tests getValueAttribute()
     * Field should get the value from pivot if exists
     * if the value is a string the string is returned
     */
    public function testGetValueAttributeWithoutPivotAndString()
    {
        // $Field = m::mock('Field');
        // $Field->value = 'test';

        // $result = $Field->getValueAttribute();

        // $this->assertEquals($result, $Field);
    }

    /**
     * tests setValueAttribute()
     * Field should call save on pivot and set attributes
     */
    public function testSetValueAttributeWithPivot()
    {
        // $Pivot = m::mock('Pivot');
        // $Pivot->shouldReceive('save')
        //     ->once();

        // $data = array('key' => 'value');

        // $Field = new Field();
        // $Field->pivot = $Pivot;
        // $result = $Field->setValueAttribute($data);
    }
}