<?php

use Devise\Pages\Helpers\Nodes;
use Mockery as m;

class NodesTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests replaceStyle()
     * testing with an existing style tag
     */
    public function testReplaceStyleWithExising()
    {
        $html = '<div style="background-image:url(../test.jpg);"></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $fieldName = 'test-name';
        $params = array('style', 'background-image');

        Nodes::replaceStyle($node, $fieldName, $params);
        $this->assertEquals($dom->saveHtml($node), '<div style="background-image:{{ $page-&gt;test-name }};"></div>');
    }

    /**
     * tests replaceStyle()
     * testing with a missing style tag
     */
    public function testReplaceStyleWithoutExising()
    {
        $html = '<div></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $fieldName = 'test-name';
        $params = array('style', 'background-image');

        Nodes::replaceStyle($node, $fieldName, $params);
        $this->assertEquals($dom->saveHtml($node), '<div style="background-image:{{ $page-&gt;test-name }}"></div>');
    }

    /**
     * tests getStyleValue()
     * testing with an existing background-image style
     */
    public function testGetStyleWithExising()
    {
        $html = '<div style="background-image:url(../test.jpg);"></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $params = array('style', 'background-image');

        $value = Nodes::getStyleValue($node, $params);
        $this->assertEquals($value, 'url(../test.jpg)');
    }
    
    /**
     * tests getStyleValue()
     * testing with a missing background-image style
     */
    public function testGetStyleWithoutExising()
    {
        $html = '<div></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $params = array('style', 'background-image');

        $value = Nodes::getStyleValue($node, $params);
        $this->assertEquals($value, '');
    }

    /**
     * tests replaceData()
     * testing with an existing data-json tag
     */
    public function testReplaceDataWithExising()
    {
        $html = '<div data-json=\'{"test":"value"}\'></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $fieldName = 'value';
        $params = array('data-json', 'test');

        Nodes::replaceData($node, $fieldName, $params);
        $this->assertEquals($dom->saveHtml($node), '<div data-json="{\'test\':\'{{ $page-&gt;value }}\'}"></div>');
    }
    
    /**
     * tests replaceData()
     * testing with a missing data-json tag
     */
    public function testReplaceDataWithoutExising()
    {
        $html = '<div></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $fieldName = 'value';
        $params = array('data-json', 'test');

        Nodes::replaceData($node, $fieldName, $params);
        $this->assertEquals($dom->saveHtml($node), '<div data-json="{\'test\':\'{{ $page-&gt;value }}\'}"></div>');
    }

    /**
     * tests getDataValue()
     * testing with an existing data-json tag
     */
    public function testGetDataValueWithExising()
    {
        $html = '<div data-json=\'{"test":"value"}\'></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $params = array('data-json', 'test');

        $value = Nodes::getDataValue($node, $params);
        $this->assertEquals($value, 'value');
    }
    
    /**
     * tests getDataValue()
     * testing with a missing data-json tag
     */
    public function testGetDataValueWithoutExising()
    {
        $html = '<div></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $params = array('data-json', 'test');

        $value = Nodes::getDataValue($node, $params);
        $this->assertEquals($value, '');
    }

    /**
     * tests addClass()
     * testing with an existing data-json tag
     */
    public function testAddClassValueWithExising()
    {
        $html = '<div class="test"></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        Nodes::addClass($node, 'tester');
        $this->assertEquals($dom->saveHtml($node), '<div class="test tester"></div>');
    }
    
    /**
     * tests addClass()
     * testing with a missing data-json tag
     */
    public function testAddClassValueWithoutExising()
    {
        $html = '<div></div>';
        $dom = HTML5::loadHTML($html);
        $node = $this->getNode($dom, 'div');

        $value = Nodes::addClass($node, 'tester');
        $this->assertEquals($dom->saveHtml($node), '<div class="tester"></div>');
    }
    
    /**
     * tests findParentTemplateName()
     * testing will find parent name of Child
     */
    public function testFindParentTemplateName()
    {
        $html = '<section data-template="Parent"><section data-template="Child"><div><section data-template="GrandChild"></section></div></section></section>';
        $dom = HTML5::loadHTML($html);
        $xpath = new DomXpath($dom);
        $node = $this->getNode($dom, 'section[@data-template="GrandChild"]');

        $parentName = Nodes::findParentTemplateName($node);
        $this->assertEquals($parentName, 'Child');
    }

    private function getNode($dom, $tagname)
    {
        $xpath = new DomXpath($dom);

        return $xpath->query("//" . $tagname)->item(0);
    }
}