<?php

use Laracasts\Integrated\Extensions\Selenium;
use Laracasts\Integrated\Services\Laravel\Application as Laravel;
use Laracasts\Integrated\Extensions\Traits\WorksWithDatabase as Database;
class Integrated extends Selenium
{
	use Laravel;
	use Database;

	/**
	 * Login to the devise admin section to some page
	 *
	 * @param  [type] $toPage
	 * @return [type]
	 */
	protected function login($toPage)
	{
		$this->visit($toPage)
			 ->seePageIs('/admin/login')
			 ->type('devise', 'uname_or_email')
			 ->type('password', 'password')
			 ->press('Log In to Administration');

		return $this;
	}

	/**
	 * Open the sidebar for a given field
	 *
	 * @param  [type] $field
	 * @return [type]
	 */
	protected function sidebar($field)
	{
		$this->login('/admin/fields')
			 ->waitForElement('#dvs-node-mode-button')
			 ->findByNameOrId('#dvs-node-mode-button')
			 ->click();

		$this->session->frame(['id' => 'dvs-iframe']);

		$this->waitForElement($field)
			 ->findByNameOrId($field)
			 ->click();

		$this->session->frame(['id' => null]);

		return $this;
	}

	/**
	 * Overrides the click because it is very
	 * limited on what we can select on
	 *
	 * @param  [type] $selector
	 * @return [type]
	 */
	protected function mousedown($selector, $timeout = 5000)
	{
		$this->session->timeouts()->postImplicit_wait(['ms' => $timeout]);
		$this->session->element('css selector', $selector)->click();
		return $this;
	}

	/**
	 * [clear description]
	 * @param  [type] $selector
	 * @return [type]
	 */
	protected function clear($selector, $timeout = 5000)
	{
		$this->session->timeouts()->postImplicit_wait(['ms' => $timeout]);
		$this->session->element('css selector', $selector)->clear();
		return $this;
	}
}