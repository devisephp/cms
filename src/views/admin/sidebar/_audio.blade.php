{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}

    @include('devise::admin.sidebar._collection_instance_id')        

    <div class="dvs-editor-values">
        {{ Form::file('file', $element->file) }}
    </div>
    <div class="dvs-editor-settings">
        @include('devise::admin.sidebar._field_scope')

        <label>
            {{ Form::checkbox('mp3', 1, $element->mp3) }}
            MP3
        </label>

        <label>
            {{ Form::checkbox('ogg', 1, $element->ogg) }}
            OGG
        </label>

        <label>
            {{ Form::checkbox('wav', $element->wav) }}
            WAV
        </label>

        {{ Form::select('audio_channels', [1, 2], $element->audio_channels) }}
        {{ Form::select('audio_bit_depth', [16, 24, 32], $element->audio_bit_depth) }}
    </div>
{{ form::close() }}