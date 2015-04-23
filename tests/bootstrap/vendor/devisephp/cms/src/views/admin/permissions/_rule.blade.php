<div class="rule">
    <label>Rule <span class="num">1</span></label><?= Form::select('rule', ['Choose a rule'] + $availableRulesList, (isset($ruleName)) ? $ruleName : null, array('class' => 'rule-name')) ?><button class="dvs-remove-rule dvs-button dvs-button-solid dvs-button-danger" type="button">&minus; Rule</button>
    @if(isset($params))
        @foreach($params as $param)
            <?= Form::text('', $param, array('class' => 'rule-param', 'placeholder' => 'Parameter')) ?>
        @endforeach
    @endif
</div>