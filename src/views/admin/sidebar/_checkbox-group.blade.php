{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-checkbox-group')) }}

    @include('devise::admin.sidebar._collection_instance_id')        
    
    <div class="dvs-editor-values">
        <h4>Values</h4>
        <div class="dvs-checkboxes">
            @if($element->value->checkboxes)
                @foreach ($element->value->checkboxes as $checkbox)
                    @php
                        $keyname = $checkbox->key;
                    @endphp
                    <div class="dvs-checkbox">
                        {{ Form::hidden($checkbox->key, 0) }}
                        <label>
                            {{ Form::checkbox($checkbox->key, 1, ($element->value->$keyname) ? $element->value->$keyname : $checkbox->default) }} <span>{{ $checkbox->label }}</span>
                        </label>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="dvs-editor-settings">
        <h4>Settings</h4>

        @include('devise::admin.sidebar._field_scope')

        <table class="dvs-checkboxes-manager">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Label</th>
                    <th>Default</th>
                    <th><button type="button" class="dvs-button dvs-button-small dvs-new-checkbox">New</button></th>
                </tr>
            </thead>
            <tbody>
                @if($element->value->checkboxes)
                    @foreach ($element->value->checkboxes as $index => $checkbox)
                        <tr class="dvs-checkbox-fields">
                            <td>{{ Form::text('checkboxes['.$index.'][key]', $checkbox->key)}}</td>
                            <td>{{ Form::text('checkboxes['.$index.'][label]', $checkbox->label)}}</td>
                            <td>{{ Form::select('checkboxes['.$index.'][default]',['Off','On'], $checkbox->default)}}</td>
                            <td><button type="button" class="dvs-button dvs-button-small dvs-table-row-delete">Delete</button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
{{ Form::close() }}

<div style="display:none">
    {{--templates will be used by js to create new table rows and checkboxes--}}
    <table><tbody class="dvs-row-template">
        <tr class="dvs-checkbox-fields">
            <td>{{ Form::text('checkboxes[0][key]')}}</td>
            <td>{{ Form::text('checkboxes[0][label]')}}</td>
            <td>{{ Form::select('checkboxes[0][default]',['Off','On'])}}</td>
            <td><button type="button" class="dvs-button dvs-button-small dvs-table-row-delete">Delete</button></td>
        </tr>
    </tbody></table>
    <div class="dvs-checkbox-template">
        <div class="dvs-checkbox">
            {{ Form::hidden('') }}
            <label>
                {{ Form::checkbox('') }} <span></span>
            </label>
        </div>
    </div>
</div>

<script type="text/javascript">
    require(['devise/app/sidebar/checkbox-group']);
</script>