<h3>Video</h3>

<p style="font-style: italic;">This field is still under development so it does not currently work as expected</p>

<video data-devise="video1, video, Video" id="example_video_1" style="clear:both" class="video-js vjs-default-skin"
    controls preload="auto"
    poster="<?= $page->video1->poster_image ?>"
    width="200"
    data-setup='{"example_option":true}'>
    <source src="<?= $page->video1->mp4_url('http://player.vimeo.com/external/118741964.sd.mp4?s=6a29d2718065da82fae299e8a0b3d2d8') ?>" type='video/mp4' />
    @if ($page->video1->webm_url) <source src="<?= $page->video1->webm_url ?>" type='video/webm' /> @endif
    @if ($page->video1->ogg_url) <source src="<?= $page->video1->ogg_url ?>" type='video/ogg' /> @endif
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<video data-devise="video1, video, Video" id="example_video_1" style="clear:both" class="video-js vjs-default-skin"
    controls preload="auto"
    poster="{{ $page->video1->poster_image }}"
    width="200"
    data-setup=\'{"example_option":true}\'>

    <source src="{{ $page->video1->mp4_url(\'http://player.vimeo.com/external/118741964.sd.mp4?s=6a29d2718065da82fae299e8a0b3d2d8\') }}" type=\'video/mp4\' />

    @if ($page->video1->webm_url) <source src="{{ $page->video1->webm_url }}" type=\'video/webm\' /> @endif
    @if ($page->video1->ogg_url) <source src="{{ $page->video1->ogg_url }}" type=\'video/ogg\' /> @endif

    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->video1',
    'values' => $page->video1,
    'descriptions' => [
        'video' => 'URL Path to the video file (if remote URL is given then fetch and encode using options below)',
        'poster_image' => 'Image to show as poster before video is loaded',
        'mp4' => 'Create/encode a mp4 file from video path URL',
        'ogg' => 'Create/encode an ogg file from video path URL',
        'webm' => 'Create/encode a webm file from video path URL',
        'audioEncoding' => 'Choose the audio encoding (not working yet)',
        'width' => 'Choose width of video (not working yet)',
        'height' => 'Choose height of video (not working yet)',
        'upscale' => 'Should the video be upscaled? (Yes or No)',
        'aspectMode' => 'Crop, stretch, pad or preserve the video aspect ratio (not working yet)',
    ],
])
