<?php namespace Devise\Pages\Interpreter;

class DeviseParserTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->DeviseParser = new DeviseParser;
	}

	public function test_it_parses()
	{
		$nodes = $this->DeviseParser->parse($this->fixture('devise-views.interpret3'));
		assertCount(3, $nodes);
	}

	public function test_it_gets_devise_tags()
	{
		$tags = $this->DeviseParser->getDeviseTags($this->fixture('devise-views.interpret3'));

		assertCount(4, $tags);

	    assertEquals("key1", $tags[0]->id);
	    assertEquals("field", $tags[0]->bindingType);
	    assertEquals(null, $tags[0]->collection);
	    assertEquals("key1", $tags[0]->key);
	    assertEquals("type", $tags[0]->type);
	    assertEquals("Human name 1", $tags[0]->humanName);
	    assertEquals(null, $tags[0]->group);
	    assertEquals(null, $tags[0]->category);
	    assertEquals(null, $tags[0]->alternateTarget);
	    assertEquals(null, $tags[0]->defaults);
	    assertEquals(" data-devise=\"key1, type, Human name 1\"", $tags[0]->value);

    	assertEquals("key2", $tags[1]->id);
    	assertEquals("field", $tags[1]->bindingType);
    	assertEquals(null, $tags[1]->collection);
    	assertEquals("key2", $tags[1]->key);
    	assertEquals("type", $tags[1]->type);
    	assertEquals("Human name 2", $tags[1]->humanName);
    	assertEquals(null, $tags[1]->group);
    	assertEquals(null, $tags[1]->category);
    	assertEquals(null, $tags[1]->alternateTarget);
    	assertEquals(null, $tags[1]->defaults);
    	assertEquals(" data-devise=\"key2, type, Human name 2\"", $tags[1]->value);

    	assertEquals("key3", $tags[2]->id);
    	assertEquals("field", $tags[2]->bindingType);
    	assertEquals(null, $tags[2]->collection);
    	assertEquals("key3", $tags[2]->key);
    	assertEquals("type", $tags[2]->type);
    	assertEquals("Human name 3", $tags[2]->humanName);
    	assertEquals(null, $tags[2]->group);
    	assertEquals(null, $tags[2]->category);
    	assertEquals(null, $tags[2]->alternateTarget);
    	assertEquals(null, $tags[2]->defaults);
    	assertEquals(" data-devise=\"key3, type, Human name 3\"", $tags[2]->value);

    	assertEquals("outside", $tags[3]->id);
    	assertEquals("field", $tags[3]->bindingType);
    	assertEquals(null, $tags[3]->collection);
    	assertEquals("outside", $tags[3]->key);
    	assertEquals("type", $tags[3]->type);
    	assertEquals("Outside Key", $tags[3]->humanName);
    	assertEquals(null, $tags[3]->group);
    	assertEquals(null, $tags[3]->category);
    	assertEquals(null, $tags[3]->alternateTarget);
    	assertEquals(null, $tags[3]->defaults);
    	assertEquals(" data-devise=\"outside, type, Outside Key\"", $tags[3]->value);
	}
}