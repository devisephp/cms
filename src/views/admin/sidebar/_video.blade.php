@php
    $loadDefaults = (!isset($element->value->video) || $element->value->video == '') ? 'dvs-editor-load-defaults' : '';
@endphp

{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        <div class="dvs-property">
            {{ Form::label('Video Path')}}
            {{ Form::text('video', $element->value->video, array('class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                                                 'data-dvs-type' => 'video',
                                                                 'data-dvs-index' => $element->index,
                                                                 'data-dvs-alternate-target' => $element->alternateTarget,
                                                                 'data-dvs-key' => $element->key)) }}
        </div>

        <div class="dvs-property">
            <button type="button" data-target="video" class="browse dvs-button mt">Browse</button>
        </div>

        <div class="dvs-property">
            <label>MP4</label>
            <div class="fancyCheckbox">
                {{ Form::checkbox('mp4', $element->mp4, null, array('id' => 'mp4')) }}
                {{ Form::label('mp4', '&nbsp;') }}
            </div>
        </div>

        <div class="dvs-property">
            <label>OGG</label>
            <div class="fancyCheckbox">
                {{ Form::checkbox('ogg', $element->ogg, null, array('id' => 'ogg')) }}
                {{ Form::label('ogg', '&nbsp;') }}
            </div>
        </div>

        <div class="dvs-property">
            <label>WebM</label>
            <div class="fancyCheckbox">
                {{ Form::checkbox('webm', $element->webm, null, array('id' => 'webm')) }}
                {{ Form::label('webm', '&nbsp;') }}
            </div>
        </div>

        <div class="dvs-property">
            {{ Form::label('Audio Encoding') }}
            {{ Form::select('audioEncoding', ['AAC'=>'AAC','MP3'=>'MP3'], $element->value->audioEncoding, ['class' => 'dvs-select']) }}
        </div>

        <div class="dvs-property">
            {{ Form::label('Width') }}
            {{ Form::text('width', $element->value->width) }}
        </div>

        <div class="dvs-property">
            {{ Form::label('Height') }}
            {{ Form::text('height', $element->value->width) }}
        </div>

        <div class="dvs-property">
            {{ Form::label('Upscale Video') }}
            <div class="fancyCheckbox">
                {{ Form::checkbox('upscale', 1, $element->value->upscale, array('id' => 'upscale')) }}
                {{ Form::label('upscale', '&nbsp;') }}
            </div>
        </div>

        <div class="dvs-property">
            {{ Form::label('Aspect Mode') }}
            {{ Form::select('aspectMode', ['Preserve'=>'Preserve','Stretch'=>'Stretch','Crop'=>'Crop','Pad'=>'Pad'], $element->value->aspectMode, ['class' => 'dvs-select']) }}
        </div>

        @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
    </div>
{{ Form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/video'], function(obj)
    {
        obj.init();
    });
</script>