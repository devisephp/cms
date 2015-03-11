@php $options = []; @endphp

<div id="dvs-sidebar-select-element">
    <?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-select-group', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>

        @include('devise::admin.sidebar._collection_instance_id')

        <div class="dvs-editor-values">

            <?= Form::label($element->human_name) ?>
            @if(isset($element->value->options) && count($element->value->options))
                @php
                    foreach($element->value->options as $option){
                        $options[ $option->value ] = $option->name;
                    }
                @endphp
            @endif

            <?= Form::select('value', count($options) ? $options : ['No options found'], null,
                array(
                    'class' => 'dvs-select dvs-liveupdate-listen',
                    'id' => 'dvs-sample-select',
                    'data-dvs-type' => 'select',
                    'data-dvs-index' => $element->index,
                    'data-dvs-alternate-target' => $element->alternateTarget,
                    'data-dvs-key' => $element->key,
                )
            ) ?>

            <hr>

            <table class="dvs-options-manager">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th><button type="button" class="dvs-button dvs-button-small dvs-new-option dvs-button-secondary">New</button></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($element->value->options) && count($element->value->options))
                        @foreach ($element->value->options as $index => $select)
                            <tr class="dvs-option-fields">
                                <td><?= Form::text('options['.$index.'][name]', $select->name)?></td>
                                <td><?= Form::text('options['.$index.'][value]', $select->value)?></td>
                                <td><button type="button" class="dvs-button dvs-button-small dvs-table-row-delete">Delete</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            @include('devise::admin.sidebar._field_scope')
        </div>
    <?= Form::close() ?>
</div>

<div style="display:none">
    <!--templates will be used by js to create new table rows and options-->
    <table><tbody class="dvs-row-template">
        <tr class="dvs-option-fields">
            <td><?= Form::text('options[0][name]')?></td>
            <td><?= Form::text('options[0][value]')?></td>
            <td><button type="button" class="dvs-button dvs-button-small dvs-table-row-delete">Delete</button></td>
        </tr>
    </tbody></table>
</div>

<script type="text/javascript">
    devise.require(['app/sidebar/select'], function(obj)
    {
        obj.init();
    });
</script>