@extends('devise::layouts.installer')

@section('content')

    <img src="<?= url('packages/devisephp/cms/img/devise-installer-logo.gif') ?>" width="300" height="300">

    <div class="main-content">

        <h1>Setup Database</h1>

        <div class="dvs-form-group">
            <label>Database Type</label>
            <select name="database_default"  class="dvs-select dvs-select-success dvs-select-small">
                <option <?= $selected('mysql') ?> value="mysql">mySQL</option>
                <option <?= $selected('pgsql') ?> value="pgsql">postgresSQL</option>
                <option <?= $selected('sqlite') ?> value="sqlite">sqlite</option>
                <option <?= $selected('sqlsrv') ?> value="sqlsrv">SQL Server</option>
            </select>
        </div>

        <div class="dvs-form-group database mysql pgsql sqlsrv">
            <label>Database Host</label>
            <input type="text" name="database_host" placeholder="Database Host" value="<?= $database->host ?>">
        </div>

        <div class="dvs-form-group database mysql pgsql sqlsrv">
            <label>Database Name</label>
            <input type="text" name="database_name" placeholder="Database Name" value="<?= $database->name ?>">
        </div>

        <div class="dvs-form-group database mysql pgsql sqlsrv">
            <label>Database Username</label>
            <input type="text" name="database_username" placeholder="Database Username" value="<?= $database->username ?>">
        </div>

        <div class="dvs-form-group database mysql pgsql sqlsrv">
            <label>Database Password</label>
            <input type="text" name="database_password" placeholder="Database Password" value="<?= $database->password ?>">
        </div>

        <div class="dvs-form-group dvs-form-actions">
            <button class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='environment'">Back</button>
            <button class="next dvs-button-success dvs-button">Next</button>
        </div>

    </div>
@stop


@section('scripts')

    <script>
        $('[name="database_default"]').change(function()
        {
            var selected = '.' + $(this).val();
            $('.database').hide();
            $(selected).show();
        });
    </script>

@stop