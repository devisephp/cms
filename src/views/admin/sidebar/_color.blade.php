@php
$loadDefaults = (!isset($element->value->color) || $element->value->color == '') ? 'dvs-editor-load-defaults' : '';
@endphp
{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put',  'class' => 'dvs-element-color')) }}
    <div class="dvs-editor-values">
        <h4>Values</h4>
        @include('devise::admin.sidebar._field_scope')

        @include('devise::admin.sidebar._collection_instance_id')        
        
        {{ Form::label($element->human_name) }}
        {{ Form::text('color', ($element->value->color) ? $element->value->color : '#428bca',  array(
                                                           'class'=>'color dvs-liveupdate-listen ' . $loadDefaults,
                                                           'data-dvs-type' => 'color',
                                                           'data-dvs-index' => $element->index,
                                                           'data-dvs-alternate-target' => $element->alternateTarget,
                                                           'data-dvs-key' => $element->key,
                                                       )) }}

    </div>
{{ Form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/color']);
</script>