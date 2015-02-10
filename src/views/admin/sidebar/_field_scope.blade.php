<!-- Display "Content Requested" Checkbox on all fields -->
<div class="dvs-property fancy-sidebar-checkbox">
    <label for="content_requested">Request Content?</label>
    <div class="fancyCheckbox">
        <?= Form::checkbox('content_requested', true, $element->content_requested, array('id' => 'content_requested')) ?>
        <?= Form::label('content_requested', '&nbsp;') ?>
    </div>
</div>


@if ($element->collection_instance_id || (isset($hide_site_wide_field) && $hide_site_wide_field))
    <!-- don't save this as global field because it belongs to a collection -->
@else

    <div class="dvs-property fancy-sidebar-checkbox">
        <label for="field_scope">Save this field site-wide?</label>
        <div class="fancyCheckbox">
            <?= Form::hidden('current_field_scope', $element->scope, array('id' => 'current_field_scope')) ?><br>
            <?= Form::checkbox('field_scope', 'global', $element->scope === 'global', array('id' => 'field_scope')) ?>
            <?= Form::label('field_scope', '&nbsp;') ?>
        </div>
    </div>

@endif