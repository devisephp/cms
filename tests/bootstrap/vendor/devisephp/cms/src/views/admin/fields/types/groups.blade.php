<h3>Groups</h3>

@snippet
<p data-devise="colorGroup, color, Color, Group Example, null, backgroundColor" style="background-color: {{ $page->color1->color('blue') }};">
	Showing the color {{ $page->colorGroup->color('pink') }}
</p>
<p data-devise="textGroup, text, Text, Group Example">
    {{ $page->textGroup->text('This is some default text') }}
<p>
@endsnippet
