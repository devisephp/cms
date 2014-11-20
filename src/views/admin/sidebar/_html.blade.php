{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        {{ Form::textarea('html', $element->value->html) }}

	    @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
    </div>
{{ form::close() }}