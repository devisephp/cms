@extends('layouts.marketing')

@section('content')

<!-- some weird style that I'm just overriding so I can see the listed attributes -->
<style>
	.dvs-test-block table tr:nth-child(odd) td {
		background-color: transparent;
	}
</style>

<div class="fg black">
<div style="padding:20px;">
    <h2 class="dvs-test-title">Editors Tests</h2>

    <ul class="dvs-test-block">
    	@foreach (['audio', 'checkbox-group', 'checkbox',
			'color', 'datetime', 'file', 'html', 'image',
			'link', 'map', 'select', 'text', 'textarea',
			'video', 'wysiwyg'] as $type)
	        <li>@include("devise::admin.fields.types.{$type}")</li>
	        <hr>
        @endforeach

        <li>
        	<div data-devise="colName[imageName], image, Image For Collection, groupName1, catName1"></div>
        	<div data-devise="colName[textName], text, Text For Collection, groupName1, catName1"></div>
        </li>
        <hr>
    </ul>
 </div>

@stop