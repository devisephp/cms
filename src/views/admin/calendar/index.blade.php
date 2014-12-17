@extends('devise::admin.layouts.master')

@section('main')

<link href="{{ URL::asset('/packages/devise/cms/css/fullcalendar.min.css') }}" rel="stylesheet">

<style>
	#modal-blind {
	   position:absolute;
	   z-index:9999;
	   top:0;
	   left:0;
	   width:100%;
	   height:100%;
	   background-color:#000000;
	}

	.modal {
	   position:absolute;
	   z-index:10000;
	   width:400px;
	   height:248px;
	   margin-left:-200px;
	   margin-top:-124px;
	   left:-1000px;
	   top:-1000px;
	   background-color:#ffffff;
	   box-shadow:4px 4px 80px #000;
	   -webkit-box-shadow:4px 4px 80px #000;
	   -moz-box-shadow:4px 4px 80px #000;
	   padding:24px;
	   color: #333;
	}

	#dvs-modal-container h1,
	#dvs-modal-container h2,
	#dvs-modal-container h3,
	#dvs-modal-container h4,
	#dvs-modal-container h5,
	#dvs-modal-container h6 {
		color: #555;
	}

	.js-template {
		display: none;
	}

	.dvs-calendar-container {
		float: left;
		width: 80%;
		padding-right: 10px;
	}

	.external-events {
		float: right;
		width: 15%;
		padding: 0 10px;
		border: 1px solid #ccc;
		text-align: left;
	}

	.external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}

</style>

<!-- calendar resides here -->
<div class="dvs-calendar-container"></div>

<!-- page versions that aren't scheduled go here -->
<div id="page-version-events" class="external-events">
	<h4>Page Versions</h4>
	@foreach ($unscheduledPageVersions as $unscheduled)
		<div class="fc-event"
			 data-title="{{$unscheduled->name}}"
			 data-update-url="{{$unscheduled->update_url}}">
			 {{$unscheduled->name}}: {{$unscheduled->page_slug}}
		</div>
	@endforeach
</div>

<!-- place to put our modal -->
<div id="dvs-modal-container" class="modal"></div>

<!-- when events are edited we want to use this template -->
<div class="edit-page-version js-template">
	<form method="POST" action="{event.update_url}">
		<input type="hidden" name="_method" value="PATCH">

		<h3>{event.title}</h3>
		<h6>{event.page.slug}</h6>

		<div>
			<label>Starts On</label>
			<input type="text" class="datetimepicker" name="start" value="{event.start}">
		</div>

		<div>
			<label>Ends On</label>
			<input type="text" class="datetimepicker" name="end" value="{event.end}">
		</div>

		<div>
			<label>Published</label>
			<input type="checkbox" name="published" value="1" checked>
		</div>
		<button class="js-save-btn">Update</button>
	</form>
</div>

<!-- script gets the calendar started -->
<script>
	requirejs(['dvsCalendar'], function(calendar)
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
				url: '{{ route("dvs-calendar-index") }}',
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