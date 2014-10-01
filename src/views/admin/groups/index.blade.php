@extends('devise::admin.layouts.master')

@section('subnavigation')
    <ul>
        <li>{{ link_to(URL::route('dvs-groups-create'), 'Create New Group', array('class'=>'dvs-button')) }}</li>
    </ul>
@stop

@section('title')

<h1>List of Groups</h1>
<h3><span>About This</span></h3>
<p>Bacon ipsum dolor sit amet pork loin chicken doner leberkas, tail jerky brisket kevin jowl meatloaf prosciutto beef ham hock meatball fatback. Turkey kevin tenderloin, pork shank boudin andouille landjaeger cow meatloaf hamburger shankle strip steak pork belly tongue. </p>

@stop

@section('main')
    @if ($groups->count() == 0)
        <h3>No groups found.</h3>
    @else
        <table class="dvs-admin-table">
            <thead>
                <th class="tal">Id</th>
                <th class="tal">Name</th>
                <th class="tal">Created At</th>
                <th class="actions">Actions</th>
            </thead>

            <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->id }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ date("m/d/Y", strtotime($group->created_at)) }}</td>
                        <td class="tac actions dvs-button-group">
                            <a class="dvs-button dvs-button-small" href="{{ route('dvs-groups-edit', $group->id) }}">Edit</a>
                            {{ Form::delete(route('dvs-groups-destroy', $group->id), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop