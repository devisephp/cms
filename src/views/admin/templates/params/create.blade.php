@extends('devise::admin.layouts.modal')

@section('content')
    <div class="dvs-admin-form-horizontal">
        <h4>Create New Param</h4>

        <table class="dvs-admin-items">
            <tr class="dvs-edit-item">
                <td class="dvs-form-group">

                    @php
                        $paramTypesList = array(
                            'input' => 'Input',
                            'params' => 'Params',
                            'variable' => 'Defined Variable',
                            'static' => 'Static Value',
                        );
                    @endphp

                    <?= Form::select('paramType', $paramTypesList, null, array('id' => 'dvs-param-type')) ?>

                    <?= Form::text('paramValue', null, array('id' => 'dvs-param-value', 'placeholder' => 'input')) ?>
                </td>
            </tr>
        </table>

        <button type="button" class="dvs-button" id="dvs-add-param">ADD PARAM</button>

        <script>
            var varName = '{{ Input::get("varName") }}';
            var paramTemplate = '@include("devise::admin.templates.params._single-js")';

            devise.require(['app/admin/template-params']);
        </script>
    </div>
@stop