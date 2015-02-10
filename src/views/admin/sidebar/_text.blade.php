@php
$loadDefaults = (!isset($element->value->text) || $element->value->text == '') ? 'dvs-editor-load-defaults' : '';
@endphp
<?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-text', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>
    <div class="dvs-editor-values">

        <div class="dvs-property">
            <?= Form::label('Text') ?>
            <?= Form::text('text', $element->value->text,
                            array(
                                'class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                'data-dvs-type' => 'text',
                                'data-dvs-index' => $element->index,
                                'data-dvs-alternate-target' => $element->alternateTarget,
                                'data-dvs-key' => $element->key,
                                'maxlength' => ($element->value->maxlength && $element->value->maxlength != '') ? $element->value->maxlength : 50)
                            ) ?>
        </div>

        <div class="dvs-property">
            <?= Form::label('Max Length') ?>
            <?= Form::text('maxlength', ($element->value->maxlength && $element->value->maxlength != '') ? $element->value->maxlength : 50) ?>
        </div>

        @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
    </div>


<?= Form::close() ?>

<script type="text/javascript">
    devise.require(['app/sidebar/text'], function(obj)
    {
        obj.init();
    });
</script>