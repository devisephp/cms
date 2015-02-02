<h3>Collections</h3>

@snippet
<div data-devise="myCollection[imageName], image, Image For Collection, groupName1, catName1"></div>
<div data-devise="myCollection[textName], text, Text For Collection, groupName1, catName1"></div>

@if (isset($myCollection))
    @foreach ($myCollection as $collection)
        {{ $collection->textName->text('default value') }}
    @endforeach
@endif
@endsnippet
