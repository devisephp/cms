<?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>

    <div class="dvs-editor-values">

        @include('devise::admin.sidebar._collection_instance_id')

        <div class="dvs-property fancy-sidebar-checkbox">
            <?= Form::hidden('value', 0) ?>

            <label><?= $element->human_name ?></label>
            <div class="fancyCheckbox">
                <?= Form::hidden('current_field_scope', $element->scope) ?><br>
                <?= Form::checkbox('value', 1, ($element->value->value && $element->value->value != '') ? $element->value->value : null, array('id' => 'value-'.$element->id)) ?>
                <?= Form::label('value-'.$element->id, '&nbsp;') ?>
            </div>
        </div>

        @include('devise::admin.sidebar._field_scope')

    </div>

<?= Form::close() ?>

<script type="text/javascript">
    devise.require(['app/sidebar/checkbox'], function(obj)
    {
        obj.init();
    });
</script>