<dt>{{ ucfirst($item['type']) }}</dt>
<dd>Name: {{ $item['name'] }}</dd>
<dd>Class: {{ Form::text('settings['. $index .'][class]', $item['class']) }}</dd>
<dd>Function Name: {{ Form::text('settings['. $index .'][function]', $item['function']) }}</dd>
<dd>Params: {{ Form::text('settings['. $index .'][params]', $item['params']) }}</dd>
@if(isset($item['existing']) && $item['existing'])
    <dd style="color:red">{{ Form::checkbox('settings['. $index .'][overwrite]') }} Overwrite Existing Variable</dd>
@endif