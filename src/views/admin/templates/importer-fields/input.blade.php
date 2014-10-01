<dt>{{ ucfirst($item['type']) }}</dt>
<dd>Name: {{ Form::text('settings['. $index .'][class]', $item['name']) }}</dd>
