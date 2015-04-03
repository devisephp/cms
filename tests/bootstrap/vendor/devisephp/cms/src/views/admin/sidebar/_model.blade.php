<ul class="dvs-sidebar-elements-and-groups js-sidebar-model-attributes">
    <li class="dvs-sidebar-elements">
        @foreach ($fields as $field)
            <button data-model-field-cid="<?= $field->cid ?>" data-model-field-alias="<?= $field->alias ?>"><?= $field->alias ?></button>
        @endforeach
    </li>
</ul>

@foreach ($fields as $field)
    <div id="dvs-sidebar-current-element" style="display: none;" data-field-container="<?= $field->cid?>" data-model-field-alias="<?= $field->alias ?>" data-field-type="model">
        @include('devise::admin.sidebar._' . $field->type, ['element' => $field->dvs_model_field, 'hide_site_wide_field' => true])
    </div>
@endforeach