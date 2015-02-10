<?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>
    <div class="dvs-editor-values">
        <?= Form::textarea('html', $element->value->html) ?>

        @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
    </div>
<?= Form::close() ?>