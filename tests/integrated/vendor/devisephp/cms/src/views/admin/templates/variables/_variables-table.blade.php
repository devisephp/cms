<div class="dvs-admin-items-wpr">
    <h3 class="dvs-pl">Variables</h3>

    <a class="dvs-button dvs-button-secondary dvs-add-button fr" href="<?= URL::route('dvs-templates-var-create', $params['templatePath']) ?>">Add New Variable</a>

    <table class="dvs-admin-items mt sp50">
        @if(count($template['vars']))
            @foreach($template['vars'] as $var => $varDataArr)

            @php
                if(is_array($varDataArr)) {
                    $pathAndMethod = explode('.', key($varDataArr));
                } else {
                    $pathAndMethod = explode('.', $varDataArr);
                }

                $classPath = array_shift($pathAndMethod);
                $methodName = is_array($pathAndMethod) ? array_shift($pathAndMethod) : '';
                $fullPath = $classPath . '.' . $methodName;
            @endphp


            <tr id="dvs-var-<?=$var?>" class="dvs-var-item" data-var-type="vars">
                <td class="dvs-form-group">
                    <?= Form::text('template[vars]['.$var.'][varName]', $var) ?>
                    <?= Form::text('template[vars]['.$var.'][classPath]', $classPath) ?>
                    <?= Form::text('template[vars]['.$var.'][methodName]', $methodName) ?>

                    <a href="<?= URL::route('dvs-templates-param-create') ?>?varName=<?=$var?>" class="dvs-button dvs-button-small dvs-add-button">Add Param</a>
                    <a href="javascript:void(0)" class="dvs-button dvs-button-small dvs-button-danger sp10 ml dvs-remove-row">Remove</a>

                    <div class="mt sp10">
                    @if(is_array($varDataArr))

                        @foreach($varDataArr[$fullPath] as $key => $parameter)

                            @include('devise::admin.templates.params._single', ['varType' => 'vars'])

                        @endforeach

                    @else

                        <div class="dvs-param-wrapper dvs-inline-block">&nbsp;</div>

                    @endif
                    </div>

                </td>
            </tr>
            @endforeach

        @else

            <tr id="no-variables">
                <td class="dvs-form-group">No variables have been set for template.</td>
            </tr>

        @endif
    </table>


    @include('devise::admin.templates.variables._new-variables-table')
</div>