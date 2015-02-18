@php
    $loadDefaults = (!isset($element->value->image) || $element->value->image == '') ? 'dvs-editor-load-defaults' : '';
@endphp

<?= Form::open(array('class' => 'dvs-element-image', 'route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>
    <div class="dvs-editor-values">

        @include('devise::admin.sidebar._collection_instance_id')

        <?= Form::label('Image Path')?>
        <?= Form::text('image', $element->value->image, array('class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                                             'data-dvs-type' => 'image',
                                                             'data-dvs-index' => $element->index,
                                                             'data-dvs-alternate-target' => $element->alternateTarget,
                                                             'data-dvs-key' => $element->key)) ?>

        <div class="dvs-sidebar-button-grid dvs-property">
            <button type="button" data-target="image" class="browse dvs-button">Select or Upload Image</button>
            <button type="button" class="js-when-has-image js-crop dvs-button dvs-button-secondary" data-target="image" <?= $loadDefaults ? 'disabled' : '' ?>>Crop Image</button>
            <?= Form::checkbox('has_thumbnail', true, $element->value->has_thumbnail, ['id' => 'has_thumbnail']) ?>
            <label class="dvs-button dvs-button-primary" for="has_thumbnail" style="display: inline;">Create Thumbnail?</label>
            <button type="button" class="js-when-has-thumbnail js-crop dvs-button dvs-button-secondary" data-target="thumbnail" data-image-width="100" data-image-height="100" <?= $element->value->has_thumbnail == true ? '' : 'disabled' ?>>Crop Thumb</button>
        </div>

        <div class="dvs-property">
            <label for="caption">Caption</label>
            <input type="text" name="alt" value="<?= $element->value->alt ?>">
        </div>

        @include('devise::admin.sidebar._field_scope')

        <!-- these fields are used for cropping and resizing image -->
        <?= Form::hidden('_crop_image', 0) ?>
        <?= Form::hidden('image_width') ?>
        <?= Form::hidden('image_height') ?>
        <?= Form::hidden('image_crop_x') ?>
        <?= Form::hidden('image_crop_y') ?>
        <?= Form::hidden('image_crop_x2') ?>
        <?= Form::hidden('image_crop_y2') ?>
        <?= Form::hidden('image_crop_w') ?>
        <?= Form::hidden('image_crop_h') ?>

        <!-- these fields are used for cropping and resizing thumbnail -->
        <?= Form::hidden('_crop_thumbnail', 0) ?>
        <?= Form::hidden('thumbnail_width') ?>
        <?= Form::hidden('thumbnail_height') ?>
        <?= Form::hidden('thumbnail_crop_x') ?>
        <?= Form::hidden('thumbnail_crop_y') ?>
        <?= Form::hidden('thumbnail_crop_x2') ?>
        <?= Form::hidden('thumbnail_crop_y2') ?>
        <?= Form::hidden('thumbnail_crop_w') ?>
        <?= Form::hidden('thumbnail_crop_h') ?>

    </div>
<?= Form::close() ?>

<script type="text/javascript">
    devise.require(['app/sidebar/image'], function(obj){
        var mediaManagerUlr = '<?= URL::route('dvs-media-manager') ?>';
        obj.init(mediaManagerUlr);
    });
</script>