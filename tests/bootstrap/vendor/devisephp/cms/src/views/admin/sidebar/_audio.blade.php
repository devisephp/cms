<?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>

    @include('devise::admin.sidebar._collection_instance_id')

        <div class="dvs-property">
            <?= Form::file('file', $element->file) ?>
        </div>

         <div class="dvs-property fancy-sidebar-checkbox">
            <label for="mp3">MP3</label>
            <div class="fancyCheckbox">
                <?= Form::checkbox('mp3', $element->mp3, null, array('id' => 'mp3')) ?>
                <?= Form::label('mp3', '&nbsp;') ?>
            </div>
        </div>

         <div class="dvs-property fancy-sidebar-checkbox">
            <label for="ogg">OGG</label>
            <div class="fancyCheckbox">
                <?= Form::checkbox('ogg', $element->ogg, null, array('id' => 'ogg')) ?>
                <?= Form::label('ogg', '&nbsp;') ?>
            </div>
        </div>

        <div class="dvs-property fancy-sidebar-checkbox">
            <label for="wav">WAV</label>
            <div class="fancyCheckbox">
                <?= Form::checkbox('wav', $element->wav, null, array('id' => 'wav')) ?>
                <?= Form::label('wav', '&nbsp;') ?>
            </div>
        </div>

        <div class="dvs-property">
            <label>Audio Channels</label>
            <?= Form::select('audio_channels', [1, 2], $element->audio_channels, array('class' => 'dvs-select dvs-button-solid')) ?>
        </div>

        <div class="dvs-property">
            <label>Audio Bit Depth</label>
            <?= Form::select('audio_bit_depth', [16, 24, 32], $element->audio_bit_depth, array('class' => 'dvs-select')) ?>
        </div>

        @include('devise::admin.sidebar._field_scope')
    </div>
<?= Form::close() ?>