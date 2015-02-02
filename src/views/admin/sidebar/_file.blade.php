{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type)) }}
    <div class="dvs-editor-values">

        <div class="dvs-property">
        {{ Form::file('file') }}
        </div>

        <div class="dvs-property">
            <label>Size Limit</label>
            {{ Form::text('sizeLimit', $element->value->sizeLimit) }}
        </div>

        <div class="dvs-property">
            <label>Allowed MIME Types</label>
            {{ Form::text('allowedTypes', $element->value->allowedTypes) }}
        </div>

        @include('devise::admin.sidebar._collection_instance_id')
        @include('devise::admin.sidebar._field_scope')
    </div>
{{ Form::close() }}