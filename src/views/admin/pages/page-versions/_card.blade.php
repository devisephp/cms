<div class="dvs-pr mb sp20">
    <input class="js-toggle-ab-testing" type="checkbox" {{ $page->ab_testing_enabled ? 'checked' : ''}}> A|B Testing Enabled
</div>

<div class="dvs-flexbox">
@foreach($page->versions as $version)
    <div class="dvs-admin-card dvs-page-versions-card @if ($version->status == 'live') live-card @endif">
        <div class="dvs-card-top"></div>
        <div class="dvs-card-bottom">
            <h4><?= $version->name ?></h4>

            @if ($version->status == 'live')
                <p class="dvs-badge green">Live</p>
            @endif

            <p>
                <?= is_null($version->starts_at) ? 'Never Starts' : date('m/d/y g:ia', strtotime($version->starts_at)) ?> -
                <?= is_null($version->ends_at) ? 'Never Ends' : date('m/d/y g:ia', strtotime($version->ends_at)) ?>
            </p>

            <div data-dvs-page-id="<?= $page->id ?>" data-dvs-version-id="<?= $version->id ?>">
                <select class="dvs-page-version-actions dvs-select">
                    <option value="">Select an action</option>
                    <option value="publish">Publish</option>
                    <option data-dvs-url="<?= route('dvs-update-page-versions-dates', $version->id) ?>" value="unpublish">Un-Publish</option>
                    <option data-dvs-url="<?= route('dvs-page-version-store') ?>" value="create-version">Create Version from This Version</option>

                    @if($version->status != 'live')
                        @if(is_null($version->preview_hash))
                            <option data-dvs-url="<?= route('dvs-toggle-page-version-share', $version->id) ?>" value="toggle-sharing">Enable Sharing</option>
                        @else
                            <option data-dvs-url="<?= route('dvs-toggle-page-version-share', $version->id) ?>" value="toggle-sharing">Disable Sharing</option>
                            <option data-dvs-url="<?= to($page->slug . '?page_version_share=' . urlencode($version->preview_hash)) ?>" value="preview">Preview</option>
                        @endif
                        @if(!$page->dvs_admin)
                            <option data-dvs-url="<?= route('dvs-delete-page-version', $version->id) ?>" value="delete">Delete</option>
                        @endif
                    @endif
                </select>
            </div>

            @if ($page->ab_testing_enabled)
                <div class="dvs-ab-testing-section mt sp20" data-dvs-page-id="<?= $page->id ?>" data-dvs-version-id="<?= $version->id ?>" data-dvs-url="<?= route('dvs-update-page-versions-ab-testing') ?>">
                    <label for="ab_test_amount" class="mr sp80">A|B Testing Shown %</label>
                    <input type="text" class="js-ab-testing-amount tac mb sp20" placeholder="%" value="{{ $version->ab_testing_amount }}">
                    <span data-dvs-document="ab-testing-shown" class="dvs-document-button"></span>
                </div>
            @endif

            <div class="dvs-publish-dates <?= $version->id ?>" style="display:none;">
                <p>Current Server Time: <strong><?= date('m/d/y H:i:s') ?></strong></p>

                <?= Form::open(array('method' => 'PUT', 'route' => array('dvs-update-page-versions-dates', $version->id))) ?>

                    @php
                        $startTime = $version->starts_at ? date('m/d/y H:i:s', strtotime($version->starts_at)) : date('m/d/y H:i:s', strtotime('now'));
                        $endTime = $version->ends_at ? date('m/d/y H:i:s', strtotime($version->ends_at)) : '';
                    @endphp

                    <?= Form::text('starts_at', $startTime, array('class' => 'dvs-date start', 'placeholder' => 'Starts At')) ?>
                    <?= Form::text('ends_at', $endTime, array('class' => 'dvs-date end', 'placeholder' => 'Ends At')) ?>

                    <label for="never">
                        <?= Form::checkbox('never') ?> Never Ends
                    </label>

                    <?= Form::submit('Submit', array('class' => 'dvs-button dvs-button-small dvs-button-solid')) ?>

                <?= Form::close() ?>
            </div>
        </div>
    </div>
@endforeach
</div>