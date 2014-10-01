<div class="dvs-sidebar-datetime-element">
{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}
    <div class="dvs-editor-values">
        <h4>Values</h4>
        {{ Form::text('datetime', ($element->value->datetime && $element->value->datetime != '') ? $element->value->datetime : date('F jS Y h:i A', strtotime('now'))) }}

        {{ Form::text('datetimevalue', ($element->value->datetimevalue && $element->value->datetimevalue != '') ? $element->value->datetimevalue : date('Y-m-d H:i:s', strtotime('now')), array('class' => 'dvs-datetime')) }}

        @include('devise::admin.sidebar._collection_instance_id')
    </div>
    <div class="dvs-editor-settings">
        <h4>Settings</h4>
        @include('devise::admin.sidebar._field_scope')
        {{ Form::label('Format') }}
        {{ Form::select('format', [
            'F jS Y h:i A' => date('F jS Y h:i A', strtotime('now')), 
            'F jS Y' => date('F jS Y', strtotime('now')),
            'm/d/Y h:i A' => date('m/d/Y h:i A', strtotime('now')), 
            'm/d/Y' => date('m/d/Y', strtotime('now'))
        ], ($element->value->format && $element->value->format != '') ? $element->value->format : 'F jS Y h:i A') }}

    </div>
{{ Form::close() }}
</div>

<script type="text/javascript">
    require(['devise/app/sidebar/datetime']);
</script>