@php
$loadDefaults = (!isset($element->value->text) || $element->value->text == '') ? 'dvs-editor-load-defaults' : '';
@endphp
{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-text')) }}
    <div class="dvs-editor-values">
        <h4>Values</h4>

        @include('devise::admin.sidebar._collection_instance_id')

        {{ Form::label('Text') }}
        {{ Form::text('text', $element->value->text,
                        array(
                            'class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                            'data-dvs-type' => 'text',
                            'data-dvs-index' => $element->index,
                            'data-dvs-alternate-target' => $element->alternateTarget,
                            'data-dvs-key' => $element->key,
                            'maxlength' => ($element->value->maxlength && $element->value->maxlength != '') ? $element->value->maxlength : 50)
                        ) }}
    </div>
    <div class="dvs-editor-settings">
        <h4>Settings</h4>
        @include('devise::admin.sidebar._field_scope')
        {{ Form::label('Max Length') }}
        {{ Form::text('maxlength', ($element->value->maxlength && $element->value->maxlength != '') ? $element->value->maxlength : 50) }}
    </div>


{{ Form::close() }}

<script type="text/javascript">
    require(['devise/app/sidebar/text']);
</script>