
@if ($element->collection_instance_id || (isset($hide_site_wide_field) && $hide_site_wide_field))
	<!-- don't save this as global field because it belongs to a collection -->
@else

	<div class="dvs-property fancy-sidebar-checkbox">
		<label for="field_scope">Save this field site-wide?</label>
		<div class="fancyCheckbox">
	        {{ Form::hidden('current_field_scope', $element->scope) }}<br>
			{{ Form::checkbox('field_scope', 'global', $element->scope === 'global', array('id' => 'field_scope')) }}
			{{ Form::label('field_scope', '&nbsp;') }}
	    </div>
	</div>


@endif