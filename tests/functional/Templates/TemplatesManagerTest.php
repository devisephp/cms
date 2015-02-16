<?php namespace Devise\Templates;

use \Illuminate\Filesystem\Filesystem as Filesystem;
use Devise\Support\Config\FileManager as ConfigFileManager;

use Mockery as m;

class TemplatesManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;
        $this->Config = m::mock('Illuminate\Config\Repository');
        $this->Framework->Config = $this->Config;

        $this->Filesystem = new Filesystem;

        $this->ConfigFileManager = m::mock(new ConfigFileManager($this->Filesystem));
        $this->TemplatesManager = new TemplatesManager($this->ConfigFileManager, $this->Framework);
    }
    
    public function test_it_can_store()
    {
        $input = array(
            'file_name' => 'new.name',
            'human_name' => 'Test Store',
            'extends' => 'test.view'
        );
        $this->Config
            ->shouldReceive('get')
            ->with('devise.templates')
            ->times(1)
            ->andReturn(array());

        $configContents = array(
            'new.name' => array(
                'human_name' => 'Test Store',
                'extends' => 'test.view'
            )
        );
        $this->ConfigFileManager
            ->shouldReceive('saveToFile')
            ->with($configContents, 'templates', 'devisephp/cms')
            ->times(1)->andReturn(true);

        assertTrue($this->TemplatesManager->storeTemplate( $input ));
    }
    
    public function test_store_validation_fails()
    {
        assertFalse($this->TemplatesManager->storeTemplate( array() ));
        assertEquals(count($this->TemplatesManager->errors), 2);
    }
    
    public function test_it_can_update()
    {
        $input = array(
            'template_path' => 'new.name',
            'template' => array(
                'human_name' => 'New Name',
                'extends' => 'test.view'
            )
        );
        $this->Config
            ->shouldReceive('get')
            ->with('devise.templates')
            ->times(1)
            ->andReturn(array('new.name'=>array()));

        $configContents = array(
            'new.name' => array(
                'human_name' => 'New Name',
                'extends' => 'test.view'
            )
        );
        $this->ConfigFileManager
            ->shouldReceive('saveToFile')
            ->with($configContents, 'templates', 'devisephp/cms')
            ->times(1)->andReturn(true);

        assertTrue($this->TemplatesManager->updateTemplate( $input ));
    }
    
    public function test_update_validation_fails()
    {
        assertFalse($this->TemplatesManager->updateTemplate( array(
            'template' => array(
                'vars' => array( 
                    array('varName' => '')
                )
            )
        )));
        assertEquals(count($this->TemplatesManager->errors), 1);
    }
    
    public function test_it_can_destroy()
    {
        $configContents = array(
            'templates.name' => array()
        );
        $this->Config
            ->shouldReceive('get')
            ->with('devise.templates')
            ->times(1)
            ->andReturn($configContents);

        $emptyArray = array();
        $this->ConfigFileManager
            ->shouldReceive('saveToFile')
            ->with($emptyArray, 'templates', 'devisephp/cms')
            ->times(1)->andReturn(true);

        assertTrue($this->TemplatesManager->destroyTemplate( 'templates.name' ));
    }
    
    public function test_it_cant_destroy()
    {
        $this->Config
            ->shouldReceive('get')
            ->with('devise.templates')
            ->times(1)
            ->andReturn(array());

        assertFalse($this->TemplatesManager->destroyTemplate( 'not.real' ));
        assertEquals(count($this->TemplatesManager->errors), 1);
    }
    
    public function test_it_can_store_simple_var()
    {
        $name = 'template.name';
        $var = array(
            'var_name' => 'var',
            'class_path' => 'Name\Space\Class',
            'method_name' => 'find',
            'params' => array()
        );

        $this->Config
            ->shouldReceive('get')
            ->with('devise.templates')
            ->times(1)
            ->andReturn(array(
                'template.name' => array('vars' => array())
            ));

        $configContents = array(
            'template.name' => array(
                'vars' => array(
                    'var' => 'Name\Space\Class.find'
                )
            )
        );
        $this->ConfigFileManager
            ->shouldReceive('saveToFile')
            ->with($configContents, 'templates', 'devisephp/cms')
            ->times(1)->andReturn(true);

        assertTrue($this->TemplatesManager->storeNewVariable($name, $var));
    }
    
    public function test_it_storeNewVariable_fails_validation()
    {
        assertFalse($this->TemplatesManager->storeNewVariable( 'not.real', array() ));
        assertEquals(count($this->TemplatesManager->errors), 3);
    }
}