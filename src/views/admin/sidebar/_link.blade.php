@php
$loadDefaults = ((!isset($element->value->url) || $element->value->url == '') && (!isset($element->value->route) || $element->value->route == '')) ? 'dvs-editor-load-defaults' : '';
@endphp
{{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'class' => 'dvs-element-link')) }}
    <div class="dvs-editor-values">

        <div class="dvs-property">
            {{ Form::label('Text') }}
            {{ Form::text('text', $element->value->text, array(
                                                            'class'=>'dvs-liveupdate-listen ' . $loadDefaults,
                                                            'data-dvs-type' => 'link',
                                                            'data-dvs-index' => $element->index,
                                                            'data-dvs-alternate-target' => $element->alternateTarget,
                                                            'data-dvs-key' => $element->key,
                                                         )) }}
        </div>

        <div class="dvs-property">
            {{ Form::label('Page') }}
            {{ Form::select('route', ['' => 'Select a Page'] + $pageRoutes, $element->value->route, array('class'=>'dvs-select')) }}
        </div>

        <div class="dvs-property">
            {{ Form::label('(or) URL') }}
            {{ Form::text('url', $element->value->url, array(
                                                             'class'=>$loadDefaults,
                                                             'data-dvs-type' => 'href',
                                                             'data-dvs-index' => $element->index,
                                                             'data-dvs-alternate-target' => $element->alternateTarget,
                                                             'data-dvs-key' => $element->key,
                                                         )) }}
        </div>

        <div class="dvs-property">
            {{ Form::label('Target') }}
            {{ Form::select('target', ['_self' => 'Same Window (_self)', '_blank' => 'New Window (_blank)'], $element->value->target, array('class'=>'dvs-select')) }}
        </div>

        @include('devise::admin.sidebar._field_scope')
        @include('devise::admin.sidebar._collection_instance_id')
    </div>
{{ form::close() }}

<script type="text/javascript">
    devise.require(['app/sidebar/link'], function(obj)
    {
        obj.init();
    });
</script>