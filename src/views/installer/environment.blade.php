@extends('devise::installer.layout')

@section('content')
    <h3>Select Environment</h3>

    <div class="dvs-form-group">
        <label>Environment</label>

        <select name="environment">
            <option value="local" <?= $selectedEnvironment('local') ?>>Local</option>
            <option value="staging" <?= $selectedEnvironment('staging') ?>>Staging</option>
            <option value="production" <?= $selectedEnvironment('production') ?>>Production</option>
            <option value="custom" <?= $selectedEnvironment('custom') ?>>Custom</option>
        </select>

        <input type="text" name="custom_environment" placeholder="Enter custom environment name" <?= $selectedEnvironment('custom', '', 'style="display: none;"') ?> value="<?= $environment ?>">
    </div>

    <div class="dvs-form-group">
        <button class="back btn" type="button" onclick="location.href='welcome'">Back</button>
        <button class="next btn">Next</button>
    </div>
@stop


@section('scripts')
<script>
    $('[name="environment"]').change(function()
    {
        if ($(this).val() === 'custom')
        {
            return $('[name="custom_environment"]').show();
        }

        $('[name="custom_environment"]').hide();
    });
</script>
@stop