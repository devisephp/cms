<?php namespace Devise\Support\Config;

use Devise\Support\ValidationException;
use Devise\Support\Framework;

class SettingsResponseHandler
{
	public function __construct(SettingsManager $SettingsManager, Framework $Framework)
	{
		$this->SettingsManager = $SettingsManager;
		$this->Redirect = $Framework->Redirect;
	}

	public function executeUpdate($input)
	{
		try
		{
			$this->SettingsManager->update($input['settings']);
		}
		catch (\ValidationException $e)
		{
	        return $this->Redirect->route('dvs-settings-index')
    	        ->withInput()
        	    ->withErrors($e->getValidator())
            	->with('message', "Invalid settings supplied");
		}

        return $this->Redirect->route('dvs-settings-index');
	}
}