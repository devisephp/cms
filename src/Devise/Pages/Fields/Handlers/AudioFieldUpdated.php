<?php namespace Devise\Pages\Fields\Handlers;

use Devise\Media\MediaPaths;
use Devise\Support\Framework;

/**
 * When the video field is updated we will
 * call this class to handle the encoding part
 * This should be registered in the Events of
 * laravel whenever the PagesServiceProvider starts
 */
class AudioFieldUpdated
{
	/**
	 * Formats that are valid to be encoded
	 *
	 * @var array
	 */
	protected $formats = ['mp3', 'aac', 'ogg'];

    /**
     * Construct a new VideoFieldUpdated instance
     *
     * @param MediaPaths $MediaPaths
     * @param null $Encoder
     */
	public function __construct(MediaPaths $MediaPaths, $Encoder = null, Framework $Framework)
	{
		$this->MediaPaths = $MediaPaths;
		$this->Encoder = $Encoder ?: $Framework->Container->make('devise.audio.encoder');
	}

	/**
	 * This is called anytime after we update a video field
	 * in devise
	 *
	 * @param  Field       $field
	 * @param  array       $input
	 * @return array
	 */
	public function handle($field, $input)
	{
		//
		// can't process imaginary files (unless you're awesome)
		//
		if ($this->noAudioPathDefined($field, $input))
		{
			return;
		}

		//
		// get the current settings we should use
		//
		$settings = $this->buildSettings($field, $input);

		//
		// need some way to determine if settings have changed since
		// the last time we ran this b/c I don't want this to run
		// every single time we save something on the video field,
		// only when something has been changed we create a job
		//
		list($unprocessed, $duplicatedFormats) = $this->findUnprocessedFiles($field, $settings);

		//
		// update this fields's {format}_url
		//
		$this->updateVersionUrls($field, $unprocessed, $duplicatedFormats);

		//
		// only process videos that haven't been processed yet
		//
		if ($unprocessed)
		{
			$this->Encoder->create($this->MediaPaths->zencoderUrl($field->values->original), $unprocessed);

			$this->createTempHoldingFiles($unprocessed);
		}
	}

	/**
	 * Find the videos that have yet to be processed by Zencoder
	 * and then we filter those out
	 *
	 * @param  Field        $field
	 * @param  array        $settings
	 * @return array($unprocessed, $duplicated)
	 */
	protected function findUnprocessedFiles($field, $settings)
	{
		$unprocessed = array();
		$duplicated = array();

		// loop through settings and see if the
		// file located at setting[label] already exists
		foreach ($settings as $setting)
		{
			if ($this->MediaPaths->fileExists($setting['label']))
			{
				$duplicated[] = $setting;
			}
			else
			{
				$unprocessed[] = $setting;
			}
		}

		return array($unprocessed, $duplicated);
	}

    /**
     * Update the verion's urls for every format
     *
     * @param  Field $field
     * @param $unprocessed
     * @param $duplicated
     * @internal param array $settings
     * @return void
     */
	protected function updateVersionUrls($field, $unprocessed, $duplicated)
	{
		foreach ($this->formats as $format)
		{
			$url = $this->findUrlForFormat($duplicated, $format);
			$url = $url ?: $this->findUrlForFormat($unprocessed, $format);

			$field->values->merge(["{$format}_url" => $url]);
		}

		$field->json_value = $field->values->toJSON();
		$field->save();
	}

	/**
	 * Find the url for the given formats
	 *
	 * @param  array  $formats
	 * @param  string $find
	 * @return string
	 */
	protected function findUrlForFormat($formats, $find)
	{
		foreach ($formats as $format)
		{
			if ($format['format'] == $find) {
				return $format['label'];
			}
		}

		return '';
	}

	/**
	 * Build out the array of settings for the audio
	 * encoding
	 *
	 * @param  Field       $field
	 * @param  array       $input
	 * @return array
	 */
	protected function buildSettings($field, $input)
	{
		$settings = array();

		foreach ($this->formats as $format)
		{
			$url = isset($field->values->$format) && $field->values->$format ? $this->filename($field->values, $format) : '';
			$audioChannels = $field->values->audio_channels(2);
			$audioBitDepth = $field->values->audio_bit_depth(16);

			if ($url)
			{
				$newSetting = array(
					'format' => $format,
					'label' => $url,
					'audio_channels' => $audioChannels,
					'audioBitDepth' => $audioBitDepth
				);

				$settings[] = $newSetting;
			}
		}

		return $settings;
	}

	/**
	 * Creates the filename for this video path and format
	 *
	 * @param  FieldValues $values
	 * @param  string      $format
	 * @return string
	 */
	protected function filename($values, $format)
	{
		$filepath = $values->original;
		$audioChannels = $values->audio_channels(2);
		$audioBitDepth = $values->audio_bit_depth(16);
		$info = $this->MediaPaths->isUrlPath($filepath) ? $this->MediaPaths->fileVersionInfoFromUrl($filepath) : $this->MediaPaths->fileVersionInfo($filepath);

		return $this->MediaPaths->makeRelativePath("{$info->versiondir}/{$info->filename}_{$audioChannels}_{$audioBitDepth}.{$format}");
	}

    /**
     * This just creates a blank file in the media-versions
     * directory because if the user saves again (shortly after),
     * we don't want to be sending multiple jobs to Zencoder.
     *
     * We only send versions of the video to Zencoder that don't
     * exist locally as a file.
     *
     * @param $unprocessed
     * @return void
     */
	protected function createTempHoldingFiles($unprocessed)
	{
		foreach ($unprocessed as $setting)
		{
			$this->MediaPaths->touch($setting['label']);
		}
	}

	/**
	 * Handle the case where the user removes the video or
	 * just doesn't specify a url path to a video
	 *
	 * @param  Field 		$field
	 * @param  array 		$input
	 * @return boolean
	 */
	protected function noAudioPathDefined($field, $input)
	{
		$filepath = trim($field->values->original);

		if (!empty($filepath))
		{
			return false;
		}

		foreach ($this->formats as $format)
		{
			$field->values->merge(["{$format}_url" => '']);
		}

		$field->json_value = $field->values->toJSON();
		$field->save();

		return true;
	}
}