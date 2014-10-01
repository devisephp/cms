{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        <h4>Values</h4>
        @include('devise::admin.sidebar._field_scope')

        @include('devise::admin.sidebar._collection_instance_id')        

        {{ Form::hidden('value', 0) }}
        
        <label>
            {{ Form::checkbox('value', 1, ($element->value->value && $element->value->value != '') ? $element->value->value : null) }} <span>{{ $element->human_name }}</span>
        </label>
    </div>


{{ Form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/checkbox']);
</script>