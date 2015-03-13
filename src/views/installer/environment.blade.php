@extends('devise::layouts.installer')

@section('content')
    <h1 class="mb sp30">Select Environment</h1>

    <p>If you're not familiar with what the "environment" name should be then select the one that makes the most sense based on where this application is. If you're working on your local machine then select "local". If this is where the final site will live, select production.</p>

    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
            <div class="dvs-form-group">

                <select name="environment" class="dvs-select dvs-select-success dvs-select-solid dvs-select-inline dvs-select-small">
                    <option value="local" <?= $selectedEnvironment('local') ?>>Local</option>
                    <option value="staging" <?= $selectedEnvironment('staging') ?>>Staging</option>
                    <option value="production" <?= $selectedEnvironment('production') ?>>Production</option>
                    <option value="custom" <?= $selectedEnvironment('custom') ?>>Custom</option>
                </select>
                <br>
            </div>
            <div class="dvs-form-group">
                <input type="text" name="custom_environment" class="form-control" placeholder="Enter custom environment name" <?= $selectedEnvironment('custom', '', 'style="display: none;"') ?> value="<?= $environment ?>">
            </div>

            <div class="dvs-form-group dvs-form-actions mt sp30">
                <button class="back dvs-button-secondary dvs-button" type="button" onclick="location.href='welcome'">Back</button>
                <button class="next dvs-button-success dvs-button">Next</button>
            </div>
    </form>
@stop


@section('scripts')
<script>
    devise.require(['jquery'], function($)
    {
        $('[name="environment"]').change(function()
        {
            if ($(this).val() === 'custom')
            {
                return $('[name="custom_environment"]').show();
            }

            $('[name="custom_environment"]').hide();
        });
    });
</script>
@stop