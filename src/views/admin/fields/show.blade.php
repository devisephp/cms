<table>
    <thead>
        <tr>
            <th>Attribute</th>
            <th>Description</th>
            <th>Current Value</th>
            <th>How To Reference</th>
        </tr>
    </thead>
    <tbody>
		@foreach ($descriptions as $key => $description)
			<tr>
				<td>{{ $key }}</td>
				<td>{{ $description }}</td>
                <td>{{ is_array($values->{$key}) ? 'array => ' . json_encode($values->{$key}) : htmlentities($values->{$key}) }}</td>
				<td>{{ $name }}->{{ $key }}</td>
			</tr>
		@endforeach

        @foreach ($values as $key => $value)
            @if (!isset($descriptions[$key]))
                <tr>
                    <td>{{ $key }}</td>
                    <td>No description found for this attribute</td>
                    <td>{{ is_array($value) ? 'array => ' . json_encode($value) : htmlentities($value) }}</td>
                    <td>{{ $name }}->{{ $key }}</td>
                </tr>
            @endif
        @endforeach

    </tbody>

</table>