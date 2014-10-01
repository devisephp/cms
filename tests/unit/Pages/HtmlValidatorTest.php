<?php

use Devise\Pages\Validators\HtmlValidator;
use Mockery as m;

class HtmlValidatorTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * test validate()
     * validator fails with invalid html
     */
    public function testInvalidHtml()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/invalid-html.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertFalse($result);
        $this->assertEquals(1, count($validator->errors));
    }

    /**
     * test validate()
     * test with an html file that the validator will find the missing "data-template" attribute
     * return false and add 1 error to the errors array
     */
    public function testMissingBodyAttribute()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/invalid-missing-body-tag.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertFalse($result);
        $this->assertEquals(1, count($validator->errors));
        foreach($validator->errors as $error) {
            $this->assertContains('Tag missing "data-template"', $error);
        }
    }

    /**
     * test validate()
     * validator will find a 2 duplicate sections, return false and add 2 errors to the errors array
     */
    public function testDuplicateSection()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/invalid-duplicate-section-name.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertFalse($result);
        $this->assertEquals(2, count($validator->errors));
        foreach($validator->errors as $error) {
            $this->assertContains('name is a duplicate', $error);
        }
    }

    /**
     * test validate()
     * validator will find missing template name on all <sections> return false, and adds 4 errors to array
     */
    public function testMissingTemplateName()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/invalid-missing-template-name.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertFalse($result);
        $this->assertEquals(4, count($validator->errors));
        foreach($validator->errors as $error) {
            $this->assertContains('Tag missing "data-name"', $error);
        }
    }

    /**
     * test validate()
     * all 'data-devise' attributes must have at least 2 options delimited by '|'
     * validator will find the attributes with less than 2 options, return false
     * and add 2 errors to array
     */
    public function testNotEnoughOptions()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/invalid-not-enough-options.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertFalse($result);
        $this->assertEquals(2, count($validator->errors));
        foreach($validator->errors as $error) {
            $this->assertContains('Tag has less than 2 options', $error);
        }
    }

    /**
     * test validate()
     * validator will find duplicate form names return false and add an error to array
     */
    public function testDuplicateForms()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/invalid-duplicate-forms.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertFalse($result);
        $this->assertEquals(1, count($validator->errors));
        foreach($validator->errors as $error) {
            $this->assertContains('"Car Form" name is a duplicate', $error);
        }
    }

    /**
     * test validate()
     * test valid file
     */
    public function testValidHtml()
    {
        $html = file_get_contents(__DIR__.'/../../files/validator/valid-file.html');

        $validator = new HtmlValidator();
        $result = $validator->validate($html);

        $this->assertTrue($result);
        $this->assertEquals(0, count($validator->errors));
    }
}