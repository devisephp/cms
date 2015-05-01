@extends('devise::layouts.installer')

@section('content')

    <h1 class="mb sp30">Setup Database</h1>

    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="form-group">
            <select tabindex="1" name="database_default"  class="dvs-select dvs-select-success dvs-select-solid dvs-select-inline dvs-select-small">
                <option <?= $selected('mysql') ?> value="mysql">mySQL</option>
                <option <?= $selected('pgsql') ?> value="pgsql">postgresSQL</option>
                <option <?= $selected('sqlite') ?> value="sqlite">sqlite</option>
                <option <?= $selected('sqlsrv') ?> value="sqlsrv">SQL Server</option>
            </select>
        </div>

        <div class="form-group database mysql pgsql sqlsrv tal">
            <label>Database Host</label>
            <input tabindex="2" type="text" class="form-control" name="database_host" placeholder="Database Host" value="<?= $database->host ?>">
        </div>

        <div class="form-group database mysql pgsql sqlsrv tal">
            <label>Database Name</label>
            <input tabindex="3" type="text" class="form-control" name="database_name" placeholder="Database Name" value="<?= $database->name ?>">
        </div>

        <div class="form-group database mysql pgsql sqlsrv tal">
            <label>Database Username</label>
            <input tabindex="4" type="text" class="form-control" name="database_username" placeholder="Database Username" value="<?= $database->username ?>">
        </div>

        <div class="form-group database mysql pgsql sqlsrv tal">
            <label>Database Password</label>
            <input tabindex="5" type="text" class="form-control" name="database_password" placeholder="Database Password" value="<?= $database->password ?>">
        </div>

        <div class="form-group dvs-form-actions mt sp30">
            <button tabindex="7" class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='environment'">Back</button>
            <button tabindex="6" class="next dvs-button-success dvs-button">Next</button>
        </div>

    </form>
@stop


@section('scripts')

<script>
    devise.require(['jquery'], function($)
    {
        $('[name="database_default"]').change(function()
        {
            var selected = '.' + $(this).val();
            $('.database').hide();
            $(selected).show();
        });
    });
</script>

@stop