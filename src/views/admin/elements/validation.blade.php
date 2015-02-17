@if(Session::has('message-success'))
    <div class="alert alert-success alert-dismissible">
        <h3 class="strong mtz"><?= Session::get('message-success') ?></h3>
    </div>
@endif

@if(Session::has('message-errors'))
    <div class="alert alert-danger alert-dismissible">
        <h3 class="strong mtz"><?= Session::get('message-errors') ?></h3>
        @if($errors->any())
            <ul class="pz"><?= implode('', $errors->all('<li class="error">:message</li>')) ?></ul>
        @endif
    </div>
@endif