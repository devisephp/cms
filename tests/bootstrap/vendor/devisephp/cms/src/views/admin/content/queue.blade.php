@extends('devise::admin.layouts.master')

@section('subnavigation')
<ul>
	<li><?= link_to(URL::route('dvs-pages-create'), 'Task Manager', array('class'=>'dvs-button')) ?></li>
</ul>
@stop

@section('title')

<h1>Content In Queue</h1>
<h3><span>About This</span></h3>
<p>Bacon ipsum dolor sit amet pork loin chicken doner leberkas, tail jerky brisket kevin jowl meatloaf prosciutto beef ham hock meatball fatback. Turkey kevin tenderloin, pork shank boudin andouille landjaeger cow meatloaf hamburger shankle strip steak pork belly tongue. </p>

@stop

@section('main')
<table class="dvs-admin-table" id="content-queue-manager">
	<tr>
		<th class="tal">
			English
		</th>
		<th class="tac">
			Person Responsible
		</th>
		<th class="tac light-border">
			Todo
		</th>
		<th class="tac">
			Staging
		</th>
		<th class="tac light-border">
			Review
		</th>
		<th class="tac">
			Pending
		</th>
		<th class="tac">
			Upcoming
		</th>
	</tr>
	<?php $currentPage = null ?>
	@foreach($fields as $field)
		@if ($currentPage == null || $currentPage !== $field->page->title)

			<?php $currentPage = $field->page->title; ?>

			<tr>
				<td>
					<strong><?= $currentPage ?></strong> - <?= $field->page->slug ?>
				</td>
				<td>&nbsp;</td>
				<td class="cq-target light-border">&nbsp;</td>
				<td class="cq-target">
					<div class="cq-dot page-dot" id="cq-page-dot-<?= $field->page->id ?>" data-page-group="<?= $field->page->id ?>" data-cq-group="<?= $field->page->id ?>">&nbsp;</div>
				</td>
				<td class="light-border cq-target">&nbsp;</td>
				<td class="cq-target">&nbsp;</td>
				<td class="cq-target">&nbsp;</td>
			</tr>
		@endif
			<tr>
				<td class="tar"><?= $field->latestVersion->value->humanName ?></td>
				<td class="tac"><?= $field->latestVersion->user->name ?></td>
				<td class="cq-target light-border">&nbsp;</td>
				<td class="cq-target">&nbsp;</td>
				<td class="cq-target light-border">
					<div class="cq-dot" data-field-id="<?= $field->id ?>" data-page-group="<?= $field->page->id ?>">&nbsp;</div>
				</td>
				<td class="cq-target">&nbsp;</td>
				<td class="cq-target">&nbsp;</td>
			</tr>
	@endforeach
</table>

<div class="dvs-admin-container">
	<?= $fields->render() ?>
</div>

<script>devise.require(['app/admin/content-queue'])</script>

@stop