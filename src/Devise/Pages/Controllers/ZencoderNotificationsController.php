<?php namespace Devise\Pages\Controllers;

use App, Response, Controller, Input;

class ZencoderNotificationsController extends Controller
{
	public function store()
	{
		$encoder = App::make('devise.video.encoder');

		$response = $encoder->handle(Input::get('output'), public_path());

		return Response::json('thanks zencoder');
	}

}