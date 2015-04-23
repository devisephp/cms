<?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-html', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>

    <div class="dvs-editor-values">

        <?= Form::textarea('html', $element->value->html, array(
                'class' => 'dvs-liveupdate-listen',
                'data-dvs-index' => $element->index,
                'data-dvs-alternate-target' => $element->alternateTarget,
                'data-dvs-key' => $element->key,
        )) ?>

        @include('devise::admin.sidebar._collection_instance_id')

        @include('devise::admin.sidebar._field_scope')
    </div>

<?= Form::close() ?>

<script type="text/javascript">
    devise.require(['app/sidebar/html'], function(obj)
    {
        obj.init();
    });
</script>