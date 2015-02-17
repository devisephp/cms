<?php namespace Devise\Support\Config;

use Mockery as m;

class SettingsResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;
        $this->Framework->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->SettingsManager = m::mock("Devise\Support\Config\SettingsManager");
        $this->SettingsResponseHandler = new SettingsResponseHandler($this->SettingsManager, $this->Framework);
    }

    public function test_it_can_execute_update()
    {
        $input = ['settings' => ['a' => 1, 'b' => 4]];
        $this->SettingsManager->shouldReceive('update')->with($input['settings'])->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('route')->with('dvs-settings-index')->once()->andReturnSelf();
        $this->SettingsResponseHandler->executeUpdate($input);
    }

    public function test_it_can_execute_update_with_validation_errors()
    {
        $input = ['settings' => ['a' => 1, 'b' => 4]];
        $errors = ['some message' => 'errors'];
        $this->SettingsManager->shouldReceive('update')->with($input['settings'])->once()->andThrow(new \Devise\Support\DeviseValidationException('Got error message here!', $errors));
        $this->Framework->Redirect->shouldReceive('route')->with('dvs-settings-index')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withInput')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withErrors')->with($errors)->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->with('message', 'Got error message here!')->once()->andReturnSelf();
        $this->SettingsResponseHandler->executeUpdate($input);
    }

}