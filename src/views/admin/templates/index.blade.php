@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>List of Templates</h1>
    </div>

    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-templates-register'), 'Register Template', array('class'=>'dvs-button')) ?>
    </div>
@stop

@section('main')
    <table class="dvs-admin-table">
		<thead>`
			<tr>
				<th class="dvs-tal">Template Name</th>
                <th>&nbsp;</th>
			</tr>
		</thead>

		<tbody id="templates">
			@foreach($templates as $templatePath => $templateName)
				<tr>
                    <td class="dvs-stacked-col">
                        <div>{{ $templateName }}</div>
                        <div class="dvs-secondary-text dvs-opaque-text">Filename: {{ $templatePath }}</div>
                    </td>
					<td class="dvs-tac dvs-button-group">
						<?= link_to(URL::route('dvs-templates-edit', array($templatePath)), 'Edit', array('class'=>'dvs-button dvs-button-small')) ?>
						<?= Form::delete(URL::route('dvs-templates-destroy', array($templatePath)), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) ?>
	                </td>
				</tr>
			@endforeach
		</tbody>

        <tfoot>
            <tr id="pagination-links">
                <td colspan="3"><?= $templates->appends(Input::except(['template']))->render() ?></td>
            </tr>
        </tfoot>
	</table>

	<script>devise.require(['app/admin/admin'])</script>
@stop