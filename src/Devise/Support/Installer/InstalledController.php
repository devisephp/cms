<?php namespace Devise\Support\Installer;

use Redirect;
use Devise\Support\Framework;
use Illuminate\Routing\Controller;

class InstalledController extends Controller
{
	/**
	 * [__construct description]
	 * @param Framework $Framework
	 */
	public function __construct(Framework $Framework)
	{
		$this->Redirect = $Framework->Redirect;
	}

	/**
	 * Welcome the installer/admin
	 *
	 * @return Redirect
	 */
	public function getIndex()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Welcome the installer/admin
	 *
	 * @return View
	 */
	public function getWelcome()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * [getInformInstallAssets description]
	 * @return [type]
	 */
	public function getInformInstallAssets()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * [getAssets description]
	 * @return [type]
	 */
	public function getAssets()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Show environment page
	 *
	 * @return View
	 */
	public function getEnvironment()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Save the environment
	 *
	 * @return Redirect
	 */
	public function postEnvironment()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Show the database page
	 *
	 * @return View
	 */
	public function getDatabase()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Save the database
	 *
	 * @return Redirect
	 */
	public function postDatabase()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Sets up the application
	 *
	 * @return Response
	 */
	public function getApplication()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Save the application setup
	 *
	 * @return Redirect
	 */
	public function postApplication()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Show the create user page
	 *
	 * @return View
	 */
	public function getCreateUser()
	{
		return $this->Redirect->to('/');
	}

	/**
	 * Save the new user and redirect them to the
	 * settings wizard
	 *
	 * @return Redirect
	 */
	public function postCreateUser()
	{
		return $this->Redirect->to('/');
	}
}