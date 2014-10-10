
@if ($element->collection_instance_id)
	<!-- don't save this as global field because it belongs to a collection -->
@else
	<label for="Save this field site-wide" for="field_scope" style="display: inline;">Save This Field Site-wide</label>
	{{ Form::hidden('current_field_scope', $element->scope) }}
	{{ Form::checkbox('field_scope', 'global', $element->scope === 'global') }}
@endif