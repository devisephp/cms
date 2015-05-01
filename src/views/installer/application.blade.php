@extends('devise::layouts.installer')

@section('content')

    <h1 class="mb sp30">Setup Application</h1>

    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="form-group database mysql pgsql sqlsrv tal">
            <label>Application Namespace</label>
            <input tabindex="2" type="text" class="form-control" name="app_name" placeholder="Application Namespace" value="<?= $appName ?>">
        </div>

        <div class="form-group tal">
            <label>Run Application Seeds/Migrations?</label><br>
            <div class="checkbox">
                <label><input tabindex="6" type="checkbox" name="app_migrations" value="yes" <?= $checked('migrations') ?> /> Migrations</label>
            </div>
            <div class="checkbox">
                <label><input tabindex="7" type="checkbox" name="app_seeds" value="yes" <?= $checked('seeds') ?> />Seeds</label>
            </div>
        </div>

         <div class="dvs-form-group tal">
            <label>Override All Devise Configs? (If you're unsure leave "on")</label><br>
            <div class="fancyCheckbox">
                <input tabindex="4" type="checkbox" name="configs_override" value="yes" id="configs-override" <?= $checked('configs_override') ?> />
                <label for="configs-override">&nbsp;</label>
            </div><br><br>
        </div>

        <div class="form-group dvs-form-actions mt sp30">
            <button tabindex="8" class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='database'">Back</button>
            <button tabindex="9" class="next dvs-button-success dvs-button">Next</button>
        </div>

    </form>
@stop


@section('scripts')

@stop