@extends('devise::installer.layout')

@section('content')
    <h3>Setup Database</h3>

    <div class="dvs-form-group">
        <label>Database Type</label>
        <select name="database_default">
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

    <div class="dvs-form-group">
        <button class="back btn" type="button" onclick="location.href='environment'">Back</button>
        <button class="next btn">Next</button>
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