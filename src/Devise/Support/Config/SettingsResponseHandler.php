<?php namespace Devise\Support\Config;

use Devise\Support\DeviseValidationException;
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
		try {
			$this->SettingsManager->update($input['settings']);
		} catch (DeviseValidationException $e) {
	        return $this->Redirect->route('dvs-settings-index')
    	        ->withInput()
        	    ->withErrors($e->getErrors())
            	->with('message', $e->getMessage());
		}

        return $this->Redirect->route('dvs-settings-index');
	}
}