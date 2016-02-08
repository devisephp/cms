<h3>Images</h3>

<img src="<?= $page->image1->image( URL::asset('/packages/devisephp/cms/img/devise-installer-logo.gif') )?>" class="dvs-test-frame" data-devise="image1, image, Image">

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<img src="{{ $page->image1->image( URL::asset(\'/packages/devisephp/cms/img/devise-installer-logo.gif\') ) }}" class="dvs-test-frame" data-devise="image1, image, Image">
') ?>
</code></pre>


@include('devise::admin.fields.show',
[
    'name' => '$page->image1',
    'values' => $page->image1,
    'descriptions' =>  [
        'original' => 'Original image that was selected from media manager',
        'image' => 'URL of the image location',
        'image_url' => 'Another way to access the URL of the image',
        'thumbnail' => 'URL of the thumbnail location',
        'thumbnail_url' => 'Another way to access the URL of the thumbnail',
        'has_thumbnail' => 'String "1" or "0" for true or false',
        'caption' => 'The intended alt tag attribute',
        'image_width' => 'Width of the image',
        'image_height' => 'Height of the image',
        'image_crop_x' => 'Top left-hand corner\'s x of the crop',
        'image_crop_y' => 'Top left-hand corner\'s y of the crop',
        'image_crop_x2' => 'Bottom right-hand corner\'s x of the crop',
        'image_crop_y2' => 'Bottom right-hand corner\'s y of the crop',
        'image_crop_w' => 'Width of the crop',
        'image_crop_h' => 'Height of the crop',
        'thumbnail_width' => 'Width of the image',
        'thumbnail_height' => 'Height of the image',
        'thumbnail_crop_x' => 'Top left-hand corner\'s x of the crop',
        'thumbnail_crop_y' => 'Top left-hand corner\'s y of the crop',
        'thumbnail_crop_x2' => 'Bottom right-hand corner\'s x of the crop',
        'thumbnail_crop_y2' => 'Bottom right-hand corner\'s y of the crop',
        'thumbnail_crop_w' => 'Width of the crop',
        'thumbnail_crop_h' => 'Height of the crop',
    ],
])

