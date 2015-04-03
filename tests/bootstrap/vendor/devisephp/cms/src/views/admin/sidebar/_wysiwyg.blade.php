
    <div id="dvs-wysiwyg-textarea">

        <div class="dvs-clearfix">
            <button class="dvs-fat-sidebar dvs-button dvs-button-small dvs-button-secondary">Full Mode</button>
            <button class="dvs-skinny-sidebar dvs-button dvs-button-small dvs-button-secondary">Skinny Mode</button>
        </div>
        <div class="dvs-clearfix">&nbsp;</div>

        <?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>

                <div class="dvs-editor-values">
                    <?= Form::textarea('text', $element->value->text,
                                array(
                                    'class'=>'dvs-wysiwyg',
                                    'data-dvs-type' => 'wysiwyg',
                                    'data-dvs-index' => $element->index,
                                    'data-dvs-alternate-target' => $element->alternateTarget,
                                    'data-dvs-key' => $element->key
                                )) ?>
                </div>

                @include('devise::admin.sidebar._collection_instance_id')
                @include('devise::admin.sidebar._field_scope')

        <?= Form::close() ?>
    </div>

    <script>
        devise.require(['app/sidebar/wysiwyg'], function(obj)
        {
            obj.init();
        });
    </script>