devise.define(['jquery'], function ( $ )
{
    var parenGrpKey = 'permissions'; // default input array key

    return {

        initialize: function()
        {

            $('#dvs-permissions').on('change', '.rule-name',function(){
                var paramAmnt = ruleParamMap[ $(this).val() ];
                var ruleDiv = $(this).closest('.rule');
                alterRuleInputs(ruleDiv, paramAmnt);
                refreshInputNames();
            });

            $('#dvs-permissions').on('change', '.operator-types', function(){
                var groupDiv = $(this).closest('.dvs-permission-group');
                groupDiv.attr('data-operator', $(this).val());
                refreshOperatorNames();
            });


            $('#dvs-permissions').on('click', '.dvs-add-group',function(){
                var groupDiv = $(this).closest('.dvs-permission-group');

                if(groupDiv.find('> .dvs-permission-group').length < 2){
                    groupDiv.append(emptyGroup);

                    var topGroupDiv = $('.dvs-form-group').find('.dvs-permission-group').first();
                    topGroupDiv.find('.dvs-permission-group').find('.dvs-remove-group').show();

                    checkGroupLimitsAndOperators(groupDiv);
                }
            });

            $('#dvs-permissions').on('click', '.dvs-add-rule',function(){
                var groupDiv = $(this).closest('.dvs-permission-group');
                var rulesDiv = groupDiv.find('.rules').first();

                if(rulesDiv.children().length > 0){
                    rulesDiv.append(operatorHtml);
                    refreshOperatorNames();
                }

                rulesDiv.append(emptyRule);
                inumerateRules();
            });

            $('#dvs-permissions').on('click', '.dvs-remove-rule', function(){
                var ruleDiv = $(this).closest('.rule');
                if(ruleDiv.prev().hasClass('operator')){
                    ruleDiv.prev().remove();
                }
                ruleDiv.remove();
                inumerateRules();
            });

            $('#dvs-permissions').on('click', '.dvs-remove-group', function(){
                var groupDiv = $(this).closest('.dvs-permission-group');
                var parentGroupDiv = groupDiv.parents().find('.dvs-permission-group');
                groupDiv.remove();

                checkGroupLimitsAndOperators(parentGroupDiv);
            });

            refreshInputNames();
            inumerateRules();
            refreshOperatorNames();
            $('.dvs-permission-group').each(function(){
                checkGroupLimitsAndOperators($(this));
            });
        },

    };

    /**
     * changes the amount of param inputs a rule has
     */
    function alterRuleInputs(target, amnt)
    {
        target.find('.rule-param').remove();
        for(var i = 0; i < amnt; i++){
            var inputHtml = emptyParamInput.replace('Parameter', 'Parameter ' + (i + 1) );
            target.append(inputHtml);
        }
    }

    /**
     * changes "name" attribute of the inputs to match the permissions.php config
     */
    function refreshInputNames()
    {
        $('.rule').each(function(){
            var keys = [];
            $(this).parents('div.dvs-permission-group').each(function(){
                var operator = $(this).attr('data-operator');
                keys.push(operator);
            });
            keys.reverse();
            var name = $('#permission-name').val();
            var amnt = keys.length;
            for(var i = 0; i < amnt; i++){
                name += '[' + keys[i] + ']';
            }
            name += '[' + $(this).find('.rule-name').first().val() + '][]';

            $(this).find('select, input').attr('name',name);
        });
    }

    /**
     * alters the numbers spans next to the rule selects
     */
    function inumerateRules()
    {
        $('.rules').each(function(){
            $(this).find('.rule').each(function(index){
                $(this).find('span').html( ( index + 1) );
            });
        });
    }

    function refreshOperatorNames()
    {
        $('.rules').each(function(){
            var groupDiv = $(this).closest('.dvs-permission-group');
            var operator = groupDiv.attr('data-operator');
            $(this).find('.operator .dvs-button').html( operator.toUpperCase() );
        });
    }

    function checkGroupLimitsAndOperators(parentGroupDiv)
    {
        if(parentGroupDiv.find('> .dvs-permission-group').length == 2){
            var firstOperator = 'and';
            parentGroupDiv.find('> .dvs-permission-group').each(function(index){
                if(index == 0){
                    firstOperator = $(this).find('.operator-types').first().val();
                    $(this).find('.operator-types').first().prop('disabled', true);
                }
                if(index == 1){
                    var newOp = (firstOperator == 'and') ? 'or' : 'and';
                    $(this).find('.operator-types').first().val(newOp);
                    $(this).find('.operator-types').first().prop('disabled', true);
                }
            });
        } else {
            parentGroupDiv.find('> .dvs-permission-group').each(function(index){
               $(this).find('.operator-types').first().prop('disabled', false);
            });
        }
    }
});