{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
	    @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
        {{ Form::textarea('html', $element->value->html) }}
    </div>
{{ form::close() }}