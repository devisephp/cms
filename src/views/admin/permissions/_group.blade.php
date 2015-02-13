<div class="group" data-operator="{{ (isset($operator)) ? $operator : 'and' }}">
    <button class="dvs-remove-group dvs-button dvs-button-danger" {{ (!isset($subgroup)) ? 'style="display:none"' : '' }} type="button">&minus; Subgroup</button>
    <button class="dvs-add-group dvs-button" type="button">&plus; Subgroup</button>
    <button class="dvs-add-rule dvs-button" type="button">&plus; Rule</button>
    <label>Operator</label>{!! Form::select('condition', ['and' => 'And','or' => 'Or'], (isset($operator)) ? $operator : null, array('class' => 'operator-types')) !!}
    <hr />
    <div class="rules">
        @if(isset($rules))
            <?php $counter = 1 ?>
            @foreach($rules as $ruleName => $params)
                @include('devise::admin.permissions._rule', array('ruleName'=>$ruleName, 'params' => $params))
                @if(count($rules) > 1 && $counter++ != count($rules))
                    @include('devise::admin.permissions._operator')
                @endif
            @endforeach
        @else
            @include('devise::admin.permissions._rule')
        @endif
    </div>

    @if(isset($groups))
        @foreach($groups as $operator => $groupData)
            @include('devise::admin.permissions._group', array('rules' => array_except($groupData,['or','and']), 'groups' => array_only($groupData,['or','and'])))
        @endforeach
    @endif

</div>