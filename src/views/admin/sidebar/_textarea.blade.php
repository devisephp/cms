@php
$loadDefaults = (!isset($element->value->text) || $element->value->text == '') ? 'dvs-editor-load-defaults' : '';
@endphp
{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-textarea')) }}

    @include('devise::admin.sidebar._collection_instance_id')

    <div class="dvs-editor-values">
        <h4>Values</h4>
        {{ Form::label('Text') }}
        {{ Form::textarea('text', $element->value->text,
                            array(
                                'class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                'data-dvs-type' => 'textarea',
                                'data-dvs-index' => $element->index,
                                'data-dvs-alternate-target' => $element->alternateTarget,
                                'data-dvs-key' => $element->key,
                                'maxlength' => ($element->value->maxlength && $element->value->maxlength != '') ? $element->value->maxlength : 500
                            )) }}
    </div>
    <div class="dvs-editor-settings">
        <h4>Settings</h4>
        @include('devise::admin.sidebar._field_scope')
        {{ Form::label('Max Length') }}
        {{ Form::text('maxlength', ($element->value->maxlength && $element->value->maxlength != '') ? $element->value->maxlength : 500) }}
    </div>
{{ Form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/textarea']);
</script>