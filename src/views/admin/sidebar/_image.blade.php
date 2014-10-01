@php
    $loadDefaults = (!isset($element->value->image) || $element->value->image == '') ? 'dvs-editor-load-defaults' : '';
@endphp

{{ Form::open(array('class' => 'dvs-element-image', 'route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        <h4>Values</h4>

        @include('devise::admin.sidebar._collection_instance_id')

        {{ Form::label('Image Path')}}
        {{ Form::text('image', $element->value->image, array('class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                                             'data-dvs-type' => 'image',
                                                             'data-dvs-index' => $element->index,
                                                             'data-dvs-alternate-target' => $element->alternateTarget,
                                                             'data-dvs-key' => $element->key)) }}

        <button type="button" class="js-when-has-image js-crop dvs-button mt" data-target="image" {{ $loadDefaults ? 'disabled' : '' }}>Crop Image</button>
        <button type="button" data-target="image" class="browse dvs-button mt pull-right">Browse</button>
    </div>
    <div class="dvs-editor-settings">
        <h4 style="clear:both;">Settings</h4>
        @include('devise::admin.sidebar._field_scope')

        <hr>

        <div>
            <label for="has_thumbnail" style="display: inline;">Create Thumbnail?</label>
            {{ Form::checkbox('has_thumbnail', true, $element->value->has_thumbnail) }}
            <button type="button" class="js-when-has-thumbnail js-crop dvs-button" data-target="thumbnail" data-image-width="100" data-image-height="100" {{ $element->value->has_thumbnail == true ? '' : 'disabled' }}>Adjust Thumbnail</button>
        </div>

        <label for="caption">Caption</label>
        <input type="text" name="alt" value="{{ $element->value->alt }}">

        <!-- these fields are used for cropping and resizing image -->
        {{ Form::hidden('_crop_image', 0) }}
        {{ Form::hidden('image_width') }}
        {{ Form::hidden('image_height') }}
        {{ Form::hidden('image_crop_x') }}
        {{ Form::hidden('image_crop_y') }}
        {{ Form::hidden('image_crop_x2') }}
        {{ Form::hidden('image_crop_y2') }}
        {{ Form::hidden('image_crop_w') }}
        {{ Form::hidden('image_crop_h') }}

        <!-- these fields are used for cropping and resizing thumbnail -->
        {{ Form::hidden('_crop_thumbnail', 0) }}
        {{ Form::hidden('thumbnail_width') }}
        {{ Form::hidden('thumbnail_height') }}
        {{ Form::hidden('thumbnail_crop_x') }}
        {{ Form::hidden('thumbnail_crop_y') }}
        {{ Form::hidden('thumbnail_crop_x2') }}
        {{ Form::hidden('thumbnail_crop_y2') }}
        {{ Form::hidden('thumbnail_crop_w') }}
        {{ Form::hidden('thumbnail_crop_h') }}

    </div>
{{ Form::close() }}

<script >


</script>
<script type="text/javascript">
    require(['devise/app/sidebar/image']);
</script>