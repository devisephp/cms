@foreach($meta as $m)
  <meta {{$m->property}}="{{ $m->key }}" value="{{ $m->value }}">
@endforeach
