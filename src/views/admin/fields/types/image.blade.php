<h3>Images</h3>

@snippet
<img src="{{ $page->image1->image_url('/imgs/default-images/special-occasions-gallery-img-2.jpg')}}" class="dvs-test-frame" data-devise="image1, image, Image">
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->imageTest',
    'values' => $page->imageTest,
    'descriptions' =>  [
        'image' => 'URL of the image location',
        'alt' => 'The intended alt tag attribute',
        'has_thumbnail' => 'String "1" or "0" for true or false',
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
        'image_url' => 'URL of the image',
        'thumbnail_url' => 'URL of the thumbnail',
    ],
])