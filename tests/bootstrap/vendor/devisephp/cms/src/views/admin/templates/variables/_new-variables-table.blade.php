@if(isset($template['newVars']) && count($template['newVars']))
    <h4 style="margin-top:60px;">New Variables</h4>

    <table class="dvs-admin-items">
        @foreach($template['newVars'] as $newVar => $newVarDataArr)

        <tr id="dvs-var-<?=$newVar?>" data-var-type="newVars">
            <td class="dvs-form-group">

                <?= Form::text('template[newVars]['.$newVar.'][varName]', $newVar, ['placeholder' => 'Variable Name']) ?>
                <?= Form::text('template[newVars]['.$newVar.'][classPath]', '', ['placeholder' => 'Class Path']) ?>
                <?= Form::text('template[newVars]['.$newVar.'][methodName]', '', ['placeholder' => 'Method Name']) ?>


                <div class="dvs-param-wrapper dvs-inline-block">&nbsp;</div>

                 <div class="mt sp10">
                    <a href="<?= URL::route('dvs-templates-param-create') ?>?varName=<?=$newVar?>" class="dvs-button dvs-button-small dvs-add-button">Add Param</a>


                    <a href="javascript:void(0)" class="dvs-button dvs-button-small dvs-button-gray sp10 ml dvs-remove-row">Remove</a>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
@endif