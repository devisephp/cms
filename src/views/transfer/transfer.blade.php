@extends('devise::layouts.admin')

@section('css')

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

@stop

@section('main')
<div class="container">
    <div class="jumbotron" style="margin-top:30px">
        <h1>Transfer Progress</h1>
        <p>{{ $node }} - {{ $transfer['percent'] }}% Complete</p>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $transfer['percent'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$transfer['percent']}}%">

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ URL::to('/transfer/'. $node) }}" class="btn btn-success btn-lg">Run again</a>
            </div>
        </div>


        @if($transfer['percent'] == 100)

            <div class="row" style="margin-top: 60px">
                <div class="col-md-6">
                    <audio controls autoplay loop>
                      <source src="https://www.freesound.org/data/previews/194/194624_3544016-lq.mp3">
                      Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        @endif


    </div>
</div>

@stop

@section('scripts')
@if ($transfer['number'] !== 'done')
<script type="application/javascript">
    $(function() {

        setTimeout(function() {
            window.location = '{{ URL::to('/transfer/'. $node . '/' . $transfer['number']) }}'
        }, 1000);

    });
</script>
@endif

@stop
