<?php namespace Devise\Media\Encoding;

/**
 * Class ZencoderNotificationsController handles incoming requests
 * from the zencoder server when it is finished encoding our videos
 * in order to let us know it is time to download the encoded video
 * back to our own servers
 *
 * @package Devise\Pages\Controllers
 */
class ZencoderNotificationsController extends \Controller
{
    /**
     * Construct a new controller
     *
     * @param null $App
     * @param null $Response
     * @param null $Input
     */
    public function __construct($App = null, $Response = null, $Input = null)
    {
        $this->App = $App ?: \App::getFacadeRoot();
        $this->Response = $Response ?: \Response::getFacadeRoot();
        $this->Input = $Input ?: \Input::getFacadeRoot();
    }

    /**
     * Stores this video file from zencoder servers onto our local server
     *
     * @return mixed
     */
	public function store()
	{
		$encoder = $this->App->make('devise.video.encoder');

		$encoder->handle($this->Input->get('output'), public_path());

		return $this->Response->json('thanks zencoder');
	}

}