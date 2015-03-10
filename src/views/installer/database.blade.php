@extends('devise::layouts.installer')

@section('content')

    <h1>Setup Database</h1>

    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="form-group">
            <label>Database Type</label>
            <select name="database_default"  class="dvs-select dvs-select-success dvs-select-small">
                <option <?= $selected('mysql') ?> value="mysql">mySQL</option>
                <option <?= $selected('pgsql') ?> value="pgsql">postgresSQL</option>
                <option <?= $selected('sqlite') ?> value="sqlite">sqlite</option>
                <option <?= $selected('sqlsrv') ?> value="sqlsrv">SQL Server</option>
            </select>
        </div>

        <div class="form-group database mysql pgsql sqlsrv">
            <label>Database Host</label>
            <input type="text" class="form-control" name="database_host" placeholder="Database Host" value="<?= $database->host ?>">
        </div>

        <div class="form-group database mysql pgsql sqlsrv">
            <label>Database Name</label>
            <input type="text" class="form-control" name="database_name" placeholder="Database Name" value="<?= $database->name ?>">
        </div>

        <div class="form-group database mysql pgsql sqlsrv">
            <label>Database Username</label>
            <input type="text" class="form-control" name="database_username" placeholder="Database Username" value="<?= $database->username ?>">
        </div>

        <div class="form-group database mysql pgsql sqlsrv">
            <label>Database Password</label>
            <input type="text" class="form-control" name="database_password" placeholder="Database Password" value="<?= $database->password ?>">
        </div>

        <div class="form-group dvs-form-actions mt sp30">
            <button class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='environment'">Back</button>
            <button class="next dvs-button-success dvs-button">Next</button>
        </div>

    </form>
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