@extends('devise::layouts.public')

@section('content')
    <div class="dvs-container pt sp45">
        <div>
            {{-- @include('admin.users.elements.validation') --}}
        </div>

@php
    $envArr = array(
        'local' => 'local',
        'staging' => 'staging',
        'production' => 'production',
        'other' => 'other'
    );
@endphp

        <div class="dvs-form-horizontal">
            {{ Form::open(array('method' => 'POST', 'route' => 'dvs-install')) }}
                <div class="dvs-form-group">
                    <label>Environment</label>
                    {{ Form::select('env', $envArr, null, array('id' => 'dvs-env')) }}
    <!-- Show env_other if "other" value is selected above -->
                    {{ Form::text('env_other', null, array('class' => 'hidden', 'placeholder' => 'Enter custom environment'))}}
                </div>

                <div class="dvs-form-group">
                    <input type="submit" class="dvs-button" value="SUBMIT" />
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop