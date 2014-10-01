{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}

    @include('devise::admin.sidebar._collection_instance_id')

    <div class="dvs-editor-values">
        <div class="dvs-google-map" style="width:300px;height:300px;"></div>
        {{ Form::label('Full Address') }}
        {{ Form::text('address', $element->value->address) }}
        {{ Form::label('latitude') }}
        {{ Form::text('latitude', $element->value->latitude) }}
        {{ Form::label('longitude') }}
        {{ Form::text('longitude', $element->value->longitude) }}
    </div>
    <div class="dvs-editor-settings">
        @include('devise::admin.sidebar._field_scope')
        {{ Form::label('Mode') }}
        {{ Form::select('mode', ['street' => 'Streets', 'satellite' => 'Satellite', 'hybrid' => 'Hybrid'], $element->value->mode) }}
        {{ Form::label('Min Zoom') }}
        {{ Form::selectRange('minZoom', 1, 19) }}
        {{ Form::label('Max Zoom') }}
        {{ Form::selectRange('maxZoom', 1, 19) }}
    </div>
{{ form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/map']);
</script>