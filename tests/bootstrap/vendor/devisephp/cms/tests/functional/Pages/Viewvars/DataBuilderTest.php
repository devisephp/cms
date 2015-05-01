<?php namespace Devise\Pages\Viewvars;

use Mockery as m;

class DataBuilderTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->DataCrawler = m::mock('Devise\Pages\Viewvars\DataCrawler');
        $this->DataBuilder = new DataBuilder($this->DataCrawler);
    }

    /**
     * @todo write a better test for this...
     */
    public function test_it_compiles()
    {
        $this->DataBuilder->compile([]);
    }

    public function test_it_sets_data()
    {
        $this->DataBuilder->setData([]);
    }

    public function test_it_gets_data()
    {
        $this->DataBuilder->getData();
    }

    public function test_it_gets_value()
    {
        $output = $this->DataBuilder->getValue('\Devise\Pages\Viewvars\SomePretendClass.itWorks');
        assertEquals('it works', $output);
    }
}

//
// we use this for test_it_gets_value
//
class SomePretendClass
{
    public function itWorks()
    {
        return 'it works';
    }
}