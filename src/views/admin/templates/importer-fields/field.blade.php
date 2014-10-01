<dt>{{ ucfirst($item['type']) }}</dt>
<dd>Name: {{ $item['name'] }}</dd>
<dd>Template: {{ Form::select('settings['. $index .'][template]', array($item['parent'] => $item['parent'], '' => 'None (Global)' ), $item['template']) }}</dd>
@if(isset($item['db-id']))
    <dd style="color:red">{{ Form::checkbox('settings['. $index .'][overwrite]') }} Overwrite Existing Field Record</dd>
@endif