@if(isset($template['newVars']) && count($template['newVars']))
    <h4 style="margin-top:60px;">New Variables</h4>

    <table class="dvs-admin-items">
        @foreach($template['newVars'] as $newVar => $newVarDataArr)

        <tr id="dvs-var-{{$newVar}}" data-var-type="newVars">
            <td class="dvs-form-group">
                <a href="javascript:void(0)" class="dvs-button dvs-button-small dvs-remove-row dvs-pl">X</a>

                <?= Form::text('template[newVars]['.$newVar.'][varName]', $newVar, ['placeholder' => 'Variable Name']) ?>
                <?= Form::text('template[newVars]['.$newVar.'][classPath]', '', ['placeholder' => 'Class Path']) ?>
                <?= Form::text('template[newVars]['.$newVar.'][methodName]', '', ['placeholder' => 'Method Name']) ?>


                <div class="dvs-param-wrapper dvs-inline-block">&nbsp;</div>

                <a href="{{ URL::route('dvs-templates-param-create') }}?varName={{$newVar}}" class="dvs-button dvs-button-small dvs-add-button">+</a>
            </td>
        </tr>
        @endforeach
    </table>
@endif