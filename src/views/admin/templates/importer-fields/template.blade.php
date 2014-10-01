<dt>Template</dt>
<dd>Template Path: {{ $item['path'] }}</dd>
@if(isset($item['existing']) && $item['existing'])
    <dd style="color:red">{{ Form::checkbox('settings['. $index .'][overwrite]') }} Overwrite Existing Template</dd>
@endif