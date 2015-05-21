<?php namespace Devise\Templates;

use Mockery as m;

class TemplatesResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;
        $this->Framework->Redirect = m::mock('\Illuminate\Routing\Redirector');

        $this->TemplatesManager = m::mock('Devise\Templates\TemplatesManager');
        $this->TemplatesResponseHandler = new TemplatesResponseHandler($this->TemplatesManager, $this->Framework);
    }

    public function test_it_can_execute_store()
    {
        $this->TemplatesManager->shouldReceive('storeTemplate')->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Template registered successfully');

        $result = $this->TemplatesResponseHandler->executeStore(['foo' => 'fooValue']);

        assertEquals('Template registered successfully', $result);
    }

    public function test_it_can_execute_update()
    {
        $this->TemplatesManager->shouldReceive('updateTemplate')->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Template updated successfully');

        $result = $this->TemplatesResponseHandler->executeUpdate('foo.templatePath', ['foo' => 'fooValue']);

        assertEquals('Template updated successfully', $result);
    }

    public function test_it_can_execute_destroy()
    {
        $this->TemplatesManager->shouldReceive('destroyTemplate')->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Template deleted successfully');

        $result = $this->TemplatesResponseHandler->executeDestroy('foo.template.path');

        assertEquals('Template deleted successfully', $result);
    }

    public function test_it_can_execute_variable_store()
    {
        $this->TemplatesManager->shouldReceive('storeNewVariable')->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Variable successfully created');

        $result = $this->TemplatesResponseHandler->executeVariableStore('foo.template.path', ['foo' => 'input']);

        assertEquals('Variable successfully created', $result);
    }

}