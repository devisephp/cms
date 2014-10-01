<dt>{{ ucfirst($item['type']) }}</dt>
<dd>Path: {{ $item['name'] }}</dd>
@if(isset($item['existing']) && $item['existing'])
    <dd style="color:red">{{ Form::checkbox('settings['. $index .'][overwrite]') }} Overwrite Existing Include</dd>
@endif