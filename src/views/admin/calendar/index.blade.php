@extends('devise::admin.layouts.master')


@section('title')

	<div id="dvs-admin-title">
        <h1><span class="ion-android-calendar"></span> Calendar</h1>
    </div>

@stop

@section('subnavigation')
	<div id="dvs-admin-actions">
        <?= Form::select('language_id', $languages, (!Input::has('language_id')) ? 45 : Input::get('language_id'), array('id' => 'lang-select', 'class' => 'dvs-select')) ?></label>
        <?= link_to(URL::route('dvs-pages-create'), 'Create New Page', array('class'=>'dvs-button')) ?>
        <?= link_to(URL::route('dvs-pages'), 'All Pages', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('modals')


    <div id="dvs-admin-blocker" class="dvs-hidden"></div>
    <div id="dvs-admin-modal" class="modal dvs-hidden"></div>

@stop

@section('main')

<link href="<?= URL::asset('/packages/devisephp/cms/css/fullcalendar.min.css') ?>" rel="stylesheet">

<!-- calendar resides here -->
<div class="dvs-calendar-container"></div>

    <div id="dvs-admin-title">
		<!-- page versions that aren't scheduled go here -->
		<div id="page-version-events" class="external-events">
			<h6>Pages needed to be scheduled</h6>
			@foreach ($unscheduledPageVersions as $unscheduled)
				<div class="fc-event dvs-button"
					 data-title="<?= $unscheduled->Page->title ?> - <?=$unscheduled->name?>"
					 data-update-url="<?=$unscheduled->update_url?>">
					 <?= $unscheduled->Page->title ?><br>
					 <?=$unscheduled->name?>: <?=$unscheduled->page_slug?>
				</div>
			@endforeach
		</div>
    </div>

<!-- when events are edited we want to use this template -->
<div class="edit-page-version js-template">
	<div class="dvs-admin-form-horizontal ">
		<form method="POST" action="{event.update_url}">
			<input type="hidden" name="_method" value="PATCH">
			<input type="hidden" name="_token" value="<?= csrf_token() ?>">

			<h3>{event.title}</h3>
			<h6>{event.page.slug}</h6>

			<div class="dvs-form-group">
				<input type="text" placehodler="Starts On" class="datetimepicker" name="start" value="{event.start}">
				<input type="text" placeholder="Ends On" class="datetimepicker" name="end" value="{event.end}">
			</div>

			<div class="dvs-form-group">
					<label>Published</label>
					<input type="checkbox" name="published" value="1" checked>
			</div>

			<button class="js-save-btn dvs-button dvs-button-secondary">Update</button>
		</form>
	</div>
</div>

<!-- script gets the calendar started -->
<script>
	devise.require(['jquery', 'dvsCalendar', 'app/admin/admin'], function($, calendar)
	{
		//
		// initialize and add draggable
		//
		calendar.init('.dvs-calendar-container');
		calendar.addDraggable('#page-version-events .fc-event');

		//
		// when we remove events we need to update unscheduled page versions
		// on the side of the calendar
		//
		$('.dvs-calendar-container').on('removeEvent', function(event)
		{
			$.ajax({
				method: 'get',
				url: '<?= route("dvs-calendar-index") ?>',
				success: function(data)
				{
					var html = $(data).find('#page-version-events').html();
					$('#page-version-events').html(html);
					calendar.addDraggable('#page-version-events .fc-event');
				}
			});
		});
	});
</script>

@endsection