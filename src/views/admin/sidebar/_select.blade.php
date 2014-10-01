{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-select-group')) }}

    @include('devise::admin.sidebar._collection_instance_id')

    <div class="dvs-editor-values">
        <h4>Values</h4>
        {{ Form::label($element->human_name) }}
        @if(isset($element->value->options) && count($element->value->options))
            @php
                $options = array();
                foreach($element->value->options as $option){
                    $options[ $option->value ] = $option->name;
                }
            @endphp
            {{ Form::select('value', $options) }}
        @else
            {{ Form::select('value', []) }}
        @endif
    </div>
    <div class="dvs-editor-settings">
        <h4>Settings</h4>
        @include('devise::admin.sidebar._field_scope')
        <table class="dvs-options-manager">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                    <th><button type="button" class="dvs-button dvs-button-small dvs-new-option">New</button></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($element->value->options) && count($element->value->options))
                    @foreach ($element->value->options as $index => $select)
                        <tr class="dvs-option-fields">
                            <td>{{ Form::text('options['.$index.'][name]', $select->name)}}</td>
                            <td>{{ Form::text('options['.$index.'][value]', $select->value)}}</td>
                            <td><button type="button" class="dvs-button dvs-button-small dvs-table-row-delete">Delete</button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
{{ Form::close() }}

<div style="display:none">
    {{--templates will be used by js to create new table rows and options--}}
    <table><tbody class="dvs-row-template">
        <tr class="dvs-option-fields">
            <td>{{ Form::text('options[0][name]')}}</td>
            <td>{{ Form::text('options[0][value]')}}</td>
            <td><button type="button" class="dvs-button dvs-button-small dvs-table-row-delete">Delete</button></td>
        </tr>
    </tbody></table>
</div>

<script type="text/javascript">
    require(['devise/app/sidebar/select']);
</script>