@php
    $loadDefaults = (!isset($element->value->video) || $element->value->video == '') ? 'dvs-editor-load-defaults' : '';
@endphp

{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        {{ Form::label('Video Path')}}
        {{ Form::text('video', $element->value->video, array('class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                                             'data-dvs-type' => 'video',
                                                             'data-dvs-index' => $element->index,
                                                             'data-dvs-alternate-target' => $element->alternateTarget,
                                                             'data-dvs-key' => $element->key)) }}
        <div>
            <button type="button" data-target="video" class="browse dvs-button mt">Browse</button>
        </div>
    </div>
    <div class="dvs-editor-settings">
        @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')

        <div>
            {{ Form::label('Available Formats') }}
            {{ Form::checkbox('mp4', 1, $element->value->mp4) }} MP4 <br />
            {{ Form::checkbox('ogg', 1, $element->value->ogg) }} Ogg <br />
            {{ Form::checkbox('webm', 1, $element->value->webm) }} WebM
        </div>

        {{ Form::label('Audio Encoding') }}
        {{ Form::select('audioEncoding', ['AAC'=>'AAC','MP3'=>'MP3'], $element->value->audioEncoding) }}

        {{ Form::label('Width') }}
        {{ Form::text('width', $element->value->width) }}

        {{ Form::label('Height') }}
        {{ Form::text('height', $element->value->width) }}

        {{ Form::label('Upscale Video') }}
        {{ Form::checkbox('upscale', 1, $element->value->upscale) }} Yes

        {{ Form::label('Aspect Mode') }}
        {{ Form::select('aspectMode', ['Preserve'=>'Preserve','Stretch'=>'Stretch','Crop'=>'Crop','Pad'=>'Pad'], $element->value->aspectMode) }}
    </div>
{{ Form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/video']);
</script>