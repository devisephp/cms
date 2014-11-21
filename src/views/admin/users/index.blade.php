@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>List of Users</h1>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-users-create'), 'Create New User', array('class'=>'dvs-button')) }}
    </div>
@stop

@section('main')
    @if (count($users) == 0)
        <h3>No users found.</h3>
    @else
        <table class="dvs-admin-table">
            <thead>
                <th class="dvs-tal">{{ Sort::link('id','Id') }}</th>
                <th class="dvs-tal">Email</th>
                <th class="dvs-tac">{{ Sort::link('created_at','Created') }}</th>
                <th>{{ Sort::clearSortLink('Clear Sort', array('class'=>'dvs-button dvs-button-small dvs-button-outset')) }}</th>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ date("m/d/Y", strtotime($user->created_at)) }}</td>
                        <td class="dvs-tac dvs-button-group">
                            <a class="dvs-button dvs-button-small" href="{{ route('dvs-users-edit', $user->id) }}">Edit</a>
                            {{ Form::delete(route('dvs-users-destroy', $user->id), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td>{{ $users->appends(Input::except(['page']))->links(); }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
@stop