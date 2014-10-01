{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        {{ Form::file('file') }}

        @include('devise::admin.sidebar._collection_instance_id')
    </div>
    <div class="dvs-editor-settings">
        @include('devise::admin.sidebar._field_scope')
        {{ Form::text('sizeLimit', $element->value->sizeLimit) }}
        {{ Form::text('allowedTypes', $element->value->allowedTypes) }}
    </div>
{{ Form::close() }}