 @php
    $pagesRepo = App::make('Devise\Pages\Repositories\PagesRepository');
    $liveVersion = $pagesRepo->getLivePageVersion($page);
@endphp

 @foreach($page->versions as $version)
    <div class="dvs-card dvs-page-versions-card">
        <h4>{{ $version->name }}</h4>

        @if($version->id == $liveVersion->id)
            <p class="dvs-badge">Live</p>
        @endif

<<<<<<< HEAD
        <p>{{ is_null($version->starts_at) ? 'Never Starts' : date('m/d/y g:i a', strtotime($version->starts_at)) }} - {{ is_null($version->ends_at) ? 'Never Ends' : date('m/d/y g:i a', strtotime($version->ends_at)) }}</p>
=======
        <p>
            {{ is_null($version->starts_at) ? 'Never Starts' : date('m/d/y g:ia', strtotime($version->starts_at)) }} -
            {{ is_null($version->ends_at) ? 'Never Ends' : date('m/d/y g:ia', strtotime($version->ends_at)) }}
        </p>
>>>>>>> master

        <div data-dvs-page-id="{{ $page->id }}" data-dvs-version-id="{{ $version->id }}">
            <select class="dvs-page-version-actions">
                <option value="">Select an action</option>
                <option value="publish">Publish</option>
                <option value="unpublish">Un-Publish</option>
                <option value="create-version">Create Version from This Version</option>

                @if($version->id != $liveVersion->id)
                    @if(is_null($version->preview_hash))
                        <option value="toggle-sharing">Enable Sharing</option>
                    @else
                        <option value="toggle-sharing">Disable Sharing</option>
                        <option value="preview" data-dvs-url="{{ URL::to($page->slug . '?page_version_share=' . $version->preview_hash) }}">Preview</option>
                    @endif
                    @if(!$page->dvs_admin)
                        <option value="delete">Delete</option>
                    @endif
                @endif
            </select>
        </div>

        <div class="dvs-publish-dates {{ $version->id }}" style="display:none;">
            <p>Current Server Time: <strong>{{ date('m/d/y H:i:s') }}</strong></p>

            {{ Form::open(array('method' => 'PUT', 'route' => array('dvs-update-page-versions-dates', $version->id))) }}

                {{ Form::text('starts_at', date('m/d/y H:i:s', strtotime($version->starts_at)), array('class' => 'dvs-date start', 'placeholder' => 'Starts At')) }}
                {{ Form::text('ends_at', date('m/d/y H:i:s', strtotime($version->ends_at)), array('class' => 'dvs-date end', 'placeholder' => 'Ends At')) }}

                <label for="never">
                    {{ Form::checkbox('never') }} Never Ends
                </label>

                {{ Form::submit('Submit', array('class' => 'dvs-button dvs-button-small')) }}

            {{ Form::close() }}
        </div>
    </div>
@endforeach