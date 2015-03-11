@php
    $loadDefaults = (!isset($element->value->video) || $element->value->video == '') ? 'dvs-editor-load-defaults' : '';
@endphp

<?= Form::open(array('class' => 'dvs-element-video', 'route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>
    <div class="dvs-editor-values">
        <div class="dvs-property">
            <?= Form::label('Video Path')?>
            <?= Form::text('video', $element->value->video, array(
                                                                'class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                                                'data-dvs-type' => 'video',
                                                                'data-dvs-index' => $element->index,
                                                                'data-dvs-alternate-target' => $element->alternateTarget,
                                                                'data-dvs-key' => $element->key)) ?>
        </div>

        <div class="dvs-property">
            <button type="button" data-target="video" class="browse dvs-button dvs-button-success dvs-button-solid">Browse</button>
        </div>

        <div class="dvs-property fancy-sidebar-checkbox">
            <label>MP4</label>
            <div class="fancyCheckbox">
                <?= Form::checkbox('mp4', true, $element->value->mp4, array('id' => 'mp4')) ?>
                <?= Form::label('mp4', '&nbsp;') ?>
            </div>
        </div>

        <div class="dvs-property fancy-sidebar-checkbox">
            <label>OGG</label>
            <div class="fancyCheckbox">
                <?= Form::checkbox('ogg', true, $element->value->ogg, array('id' => 'ogg')) ?>
                <?= Form::label('ogg', '&nbsp;') ?>
            </div>
        </div>

        <div class="dvs-property fancy-sidebar-checkbox">
            <label>WebM</label>
            <div class="fancyCheckbox">
                <?= Form::checkbox('webm', true, $element->value->webm, array('id' => 'webm')) ?>
                <?= Form::label('webm', '&nbsp;') ?>
            </div>
        </div>

        <div class="dvs-property ">
            <?= Form::label('Audio Encoding') ?>
            <?= Form::select('audioEncoding', ['AAC'=>'AAC','MP3'=>'MP3'], $element->value->audioEncoding, ['class' => 'dvs-select dvs-button-solid']) ?>
        </div>

        <div class="dvs-property">
            <?= Form::label('Width') ?>
            <?= Form::text('width', $element->value->width) ?>
        </div>

        <div class="dvs-property">
            <?= Form::label('Height') ?>
            <?= Form::text('height', $element->value->width) ?>
        </div>

        <div class="dvs-property fancy-sidebar-checkbox">
            <?= Form::label('Upscale Video') ?>
            <div class="fancyCheckbox">
                <?= Form::checkbox('upscale', 1, $element->value->upscale, array('id' => 'upscale')) ?>
                <?= Form::label('upscale', '&nbsp;') ?>
            </div>
        </div>

        <div class="dvs-property">
            <?= Form::label('Aspect Mode') ?>
            <?= Form::select('aspectMode', ['Preserve'=>'Preserve','Stretch'=>'Stretch','Crop'=>'Crop','Pad'=>'Pad'], $element->value->aspectMode, ['class' => 'dvs-select dvs-button-solid']) ?>
        </div>

        @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
    </div>
<?= Form::close() ?>

<script type="text/javascript">
    devise.require(['app/sidebar/video'], function(obj)
    {
        var mediaManagerUlr = '<?= URL::route('dvs-media-manager') ?>';
        obj.init(mediaManagerUlr);
    });
</script>