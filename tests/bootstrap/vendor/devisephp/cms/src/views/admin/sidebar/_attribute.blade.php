@foreach ($fields as $field)
    <div id="dvs-sidebar-current-element" style="display: block;" data-field-container="<?= $field->cid?>"  data-model-field-alias="<?= $field->alias ?>" data-model-field-type="attribute">
        @include('devise::admin.sidebar._' . $field->type, ['element' => $field->dvs_model_field, 'hide_site_wide_field' => true])
    </div>
@endforeach