<html>

<head>

<!-- some weird style that I'm just overriding so I can see the listed attributes -->
<style>
    .dvs-test-block table tr:nth-child(odd) td {
        background-color: transparent;
    }
</style>

@include('devise::styles')

</head>
<body>

<div style="padding:20px;">
    <h2 class="dvs-test-title">Editors Tests</h2>

    <ul class="dvs-test-block">

    	@foreach (['model', 'model-attribute', 'model-group',
            'audio', 'checkbox-group', 'checkbox', 'color',
            'datetime', 'file', 'html', 'image',
			'link', 'map', 'select', 'text', 'textarea',
			'video', 'wysiwyg', 'collections', 'hidden-fields'] as $type)
	        <li>@include("devise::admin.fields.types.{$type}")</li>
	        <hr>
        @endforeach

    </ul>
 </div>

 @include('devise::scripts')

</body>

</html>