{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}

    @include('devise::admin.sidebar._collection_instance_id')        

        <div class="dvs-property">
            {{ Form::file('file', $element->file) }}
        </div>

         <div class="dvs-property">
            <label>MP3</label>
            <div class="fancyCheckbox">
                {{ Form::checkbox('mp3', $element->mp3, null, array('id' => 'mp3')) }}
                {{ Form::label('mp3', '&nbsp;') }}
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
            <label>WAV</label>
            <div class="fancyCheckbox">
                {{ Form::checkbox('wav', $element->wav, null, array('id' => 'wav')) }}
                {{ Form::label('wav', '&nbsp;') }}
            </div>
        </div>

        <div class="dvs-property">
            <label>Audio Channels</label>
            {{ Form::select('audio_channels', [1, 2], $element->audio_channels, array('class' => 'dvs-select')) }}
        </div>

        <div class="dvs-property">
            <lable>Audio Bit Depth</lable>
            {{ Form::select('audio_bit_depth', [16, 24, 32], $element->audio_bit_depth, array('class' => 'dvs-select')) }}
        </div>

        @include('devise::admin.sidebar._field_scope')
    </div>
{{ form::close() }}