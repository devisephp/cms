@extends('devise::admin.layouts.modal')

@section('content')
    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('method' => 'POST', 'route' => array('dvs-templates-var-store', $params['templatePath']))) ?>
            <h4>Create New Variable</h4>

            <table class="dvs-admin-items">
                <tr class="dvs-edit-item">
                    <td class="dvs-form-group">
                        <?= Form::text('var_name', null, ['placeholder' => 'Variable Name']) ?>
                        <?= Form::text('class_path', null, ['placeholder' => 'Class Path']) ?>
                        <?= Form::text('method_name', null, ['placeholder' => 'Method Name']) ?>
                    </td>
                </tr>
            </table>

            <button type="submit" class="dvs-button dvs-button-secondary mt sp30" id="dvs-add-variable">ADD VARIABLE</button>
        <?=Form::close() ?>
    </div>
@stop