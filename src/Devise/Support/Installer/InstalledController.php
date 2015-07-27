<?php namespace Devise\Support\Installer;

use Redirect;
use Illuminate\Routing\Controller;

class InstalledController extends Controller
{
	/**
	 * Welcome the installer/admin
	 *
	 * @return Redirect
	 */
	public function getIndex()
	{
		return Redirect::to('/');
	}

	/**
	 * Welcome the installer/admin
	 *
	 * @return View
	 */
	public function getWelcome()
	{
		return Redirect::to('/');
	}

	/**
	 * [getInformInstallAssets description]
	 * @return [type]
	 */
	public function getInformInstallAssets()
	{
		return Redirect::to('/');
	}

	/**
	 * [getAssets description]
	 * @return [type]
	 */
	public function getAssets()
	{
		return Redirect::to('/');
	}

	/**
	 * Show environment page
	 *
	 * @return View
	 */
	public function getEnvironment()
	{
		return Redirect::to('/');
	}

	/**
	 * Save the environment
	 *
	 * @return Redirect
	 */
	public function postEnvironment()
	{
		return Redirect::to('/');
	}

	/**
	 * Show the database page
	 *
	 * @return View
	 */
	public function getDatabase()
	{
		return Redirect::to('/');
	}

	/**
	 * Save the database
	 *
	 * @return Redirect
	 */
	public function postDatabase()
	{
		return Redirect::to('/');
	}

	/**
	 * Sets up the application
	 *
	 * @return Response
	 */
	public function getApplication()
	{
		return Redirect::to('/');
	}

	/**
	 * Save the application setup
	 *
	 * @return Redirect
	 */
	public function postApplication()
	{
		return Redirect::to('/');
	}

	/**
	 * Show the create user page
	 *
	 * @return View
	 */
	public function getCreateUser()
	{
		return Redirect::to('/');
	}

	/**
	 * Save the new user and redirect them to the
	 * settings wizard
	 *
	 * @return Redirect
	 */
	public function postCreateUser()
	{
		return Redirect::to('/');
	}
}