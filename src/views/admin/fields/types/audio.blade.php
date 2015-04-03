<h3>Audio</h3>

<p style="font-style: italic;">This field is still under development so it does not currently work as expected</p>

<audio data-devise="audio1, audio, Audio" src="<?= $page->audio1->file ?>" controls loop>
    HTML5 audio not supported
</audio>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<audio data-devise="audio1, audio, Audio" src="<?= $page->audio1->file ?>" controls loop>
    HTML5 audio not supported
</audio>')
?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->audio1',
    'values' => $page->audio1,
    'descriptions' => [
        'file' => 'URL of the audio file location',
        'mp3' => 'Create/encode file to mp3 version',
        'mp3_url' => 'URL of the mp3 location',
        'ogg' => 'Create/encode file to ogg version',
        'ogg_url' => 'URL of the ogg location',
        'wav' => 'Create/encode file to wav version',
        'wav_url' => 'URL of the wav location',
        'audio channels' => 'How many channels do we have, 1 or 2? Mono or stereo?',
        'audio_bit_depth' => 'The audio depth can be set to 16, 24 or 32 bits.',
    ],
])