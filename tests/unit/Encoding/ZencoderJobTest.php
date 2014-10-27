<?php

use \Event;

class ZencoderJobTest extends \DeviseTestCase
{
	/**
	 * setup a Zencoder test
	 */
	public function setUp()
	{
		parent::setUp();

		// keep downloads from happening with a Mock file
		$this->downloader = $this->getMock('Devise\Common\FileDownloader');

		// setup job and fixtures
		$this->job = new Devise\Encoding\ZencoderJob('apikey', ['email@address.com'], $this->downloader);
	}

	/**
	 * reset the laravel application because we polluted \Event
	 */
	public function tearDown()
	{
		$this->resetApplication();
	}

	/**
	 * we should expect a few things to happen when we handle a job
	 * with data input. the file should be downloaded and an event
	 * will be fired
	 */
	public function test_it_can_handle_zencoder_data()
	{
		// fixtuers in an array file (this is data we expect back from zencoder)
		$fixtures = $this->fixture('zencoder.0');

		// override the downloader so we don't try to download stuff
		$this->downloader->expects($this->once())->method('download')->with($fixtures['output']['url'], '/some/path/to', 'video1.mp4')->will($this->returnValue('/some/path/to/video1.mp4'));

		// make sure event is called with the new file and output data
		// Event::shouldReceive('fire')->once()->with('devise.encoding.zencoder.finished', array('/some/path/to/video1.mp4', $fixtures['output']));

		// make sure things happen correctly?
		$this->job->handle($fixtures['output'], '/some/path/to');
	}

	/**
	 * make sure that zencoder will create the jobs correctly
	 * be correctly setting up the options to be sent to the api
	 */
	public function test_it_can_create_zencoder_jobs()
	{
		$expectedSettings = [
			'input' => '/public/media/video1.mov',
			'outputs' => [
				[
					"label" =>"video1.mp4",
					"notifications" => ["email@address.com"],
					"format" => "mp4",
				],
			],
		];

		// override the Zencoder class so we don't send
		// api requests to the server
		$jobs = $this->getMock('FakeClass', ['create']);
		$jobs->expects($this->once())->method('create')
			 ->with($expectedSettings)->will($this->returnValue('foo'));
		$this->job->Zencoder->jobs = $jobs;

		// attempt to create the job
		$this->job->create('/public/media/video1.mov', array([
			'format' => 'mp4',
			'label' => 'video1.mp4'
		]));
	}

	/**
	 * make sure that zencoder will create the jobs correctly
	 * be correctly setting up the options to be sent to the api
	 *
	 * @expectedException Devise\Encoding\Exceptions\InvalidEncodingSettingsException
	 */
	public function test_it_cannot_create_job_with_invalid_settings()
	{
		$this->job->create('/public/media/video1.mov', array());
	}

}