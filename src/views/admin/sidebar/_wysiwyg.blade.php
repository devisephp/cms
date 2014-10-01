
    <div id="dvs-wysiwyg-textarea">

        <div class="dvs-margin dvs-clearfix">
            <button class="dvs-fat-sidebar dvs-button dvs-button-small">Full Mode</button>
            <button class="dvs-skinny-sidebar dvs-button dvs-button-small">Skinny Mode</button>
        </div>
        <div class="dvs-clearfix">&nbsp;</div>

        {{ Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put')) }}

                @include('devise::admin.sidebar._collection_instance_id')

                @include('devise::admin.sidebar._field_scope')
                <div class="dvs-editor-values">
                    {{ Form::textarea('text', $element->value->text, array('class' => 'dvs-wysiwyg')) }}
                </div>
        {{ Form::close() }}
    </div>


<script>require(['devise/app/sidebar/wysiwyg'])</script>