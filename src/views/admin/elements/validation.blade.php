@if(Session::has('message-success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        
        <h3 class="strong mtz">{{ Session::get('message-success') }}</h3>
    </div>
@endif

@if(Session::has('message-errors'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>

        <h3 class="strong mtz">{{ Session::get('message-errors') }}</h3>
        @if($errors->any())
            <ul class="pz">{{ implode('', $errors->all('<li class="error">:message')) }}</ul>
        @endif
    </div>
@endif