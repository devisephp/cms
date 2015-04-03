<?php namespace Devise\Media\Encoding;

use Devise\Support\Framework;
use Illuminate\Routing\Controller;

/**
 * Class ZencoderNotificationsController handles incoming requests
 * from the zencoder server when it is finished encoding our videos
 * in order to let us know it is time to download the encoded video
 * back to our own servers
 *
 * @package Devise\Pages\Controllers
 */
class ZencoderNotificationsController extends Controller
{
    /**
     * Create a new ZencoderNotificationsController
     *
     * @param Framework $Framework
     */
    public function __construct(Framework $Framework)
    {
        $this->App = $Framework->Container;
        $this->Input = $Framework->Input;
        $this->Response = $Framework->Response;
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