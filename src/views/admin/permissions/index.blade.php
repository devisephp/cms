@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>List of Permissions</h1>
    </div>

    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-permissions-create'), 'Create New Permission', array('class'=>'dvs-button')) ?>
    </div>
@stop

@section('main')
    <table class="dvs-admin-table">
		<thead>
			<tr>
                <th class="dvs-tal">Permission Name</th>
				<th class="dvs-tal">Condition(s)</th>
                <th>&nbsp;</th>
			</tr>
		</thead>

		<tbody id="permissions">
			@foreach($permissions as $permissionName => $conditions)
                <tr>
                    <td><?= $permissionName ?></td>
                    <td>
                        @foreach($conditions as $conditionName => $condition)
                            <?= $conditionName ?>
                        @endforeach
                    </td>
					<td class="dvs-tac dvs-button-group">
						<?= link_to(URL::route('dvs-permissions-edit').'?condition='.$permissionName, 'Edit', array('class'=>'dvs-button dvs-button-small')) ?>
						<?= Form::delete(URL::route('dvs-permissions-destroy').'?condition='.$permissionName, 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) ?>
	                </td>
				</tr>
			@endforeach
		</tbody>

        <tfoot>
            <tr id="pagination-links">
                <td colspan="3"><?= $permissions->appends(Input::except(['permission']))->render() ?></td>
            </tr>
        </tfoot>
	</table>

	<script>devise.require(['app/admin/admin'])</script>
@stop