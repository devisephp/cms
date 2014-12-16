@extends('devise::admin.layouts.master')

@section('main')

<link href="{{ URL::asset('/packages/devise/cms/css/fullcalendar.min.css') }}" rel="stylesheet">

<div class="dvs-calendar-container"></div>


<script>
	requirejs(['dvsCalendar'], function(calendar){
		calendar.init('.dvs-calendar-container');
	});
</script>

@endsection