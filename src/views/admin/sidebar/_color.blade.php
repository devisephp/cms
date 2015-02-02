@php
    $loadDefaults = (!isset($element->value->color) || $element->value->color == '') ? 'dvs-editor-load-defaults' : '';
@endphp

{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put',  'class' => 'dvs-element-color', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type)) }}
    <div class="dvs-editor-values">

        @include('devise::admin.sidebar._collection_instance_id')

        <div class="dvs-property">

          {{ Form::label($element->human_name) }}
          {{ Form::text('color', ($element->value->color) ? $element->value->color : '#428bca',
          array(
               'class'=>'color dvs-liveupdate-listen ' . $loadDefaults,
               'data-dvs-type' => 'color',
               'data-dvs-index' => $element->index,
               'data-dvs-alternate-target' => $element->alternateTarget,
               'data-dvs-key' => $element->key,
           )) }}
        </div>

        @include('devise::admin.sidebar._field_scope')

    </div>
{{ Form::close() }}

<script type="text/javascript">
  devise.require(['app/sidebar/color'], function(obj)
  {
      obj.init();
  });
</script>