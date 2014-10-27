@extends('devise::admin.layouts.master')

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

        @if ($page->hiddenTestField->text('Hidden') != 'Hidden')
            <li>
                <div data-devise="hiddenTestField, text">{{ $page->hiddenTestField->text('Hidden') }}</div>
            </li>
        @end

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

        <li>
            <div data-devise="colName2, image, Image For Collection"></div>
            <div data-devise="colName3, text, Text For Collection"></div>
        </li>
        <hr>

        @if (isset($colName))
            @foreach ($colName as $col)
                {{ $col->textName->text('hmm') }}
            @endforeach
        @endif
    </ul>
 </div>

@stop