devise.define(['jquery'], function ( $ )
{

    function initialize()
    {
        addListeners();
    }

    function addListeners()
    {
        // changes placeholder text when select is changed
        $('#dvs-admin').on('change', '#dvs-param-type', function() {
            switchPlaceholderValue(this.value);
        });

        // listener for click of "save param" button
        $('#dvs-admin').on('click', '#dvs-add-param', function(e) {
            attemptParamAdd();
        });
    }

    /**
     * Changes value of placeholder text based-on selected param type
     *
     * @param  {string} _paramType
     * @return {void}
     */
    function switchPlaceholderValue(_paramType)
    {
        var placeholderText = '';

        switch(_paramType) {
            case 'input':
                placeholderText = 'Enter an input value (e.g. input)';
                break;

            case 'params':
                placeholderText = 'Enter a params value (e.g. params.id)';
                break;

            case 'variable':
                placeholderText = 'Enter an already defined variable';
                break;

            case 'static':
                placeholderText = 'Enter a static value (e.g. True)';
                break;

            case 'boolean':
                placeholderText = 'True or False';
                break;
        }

        return $('#dvs-param-value').attr('placeholder', placeholderText);
    }

    /**
     * Processes submission of param create form
     *
     * @return {void}
     */
    function attemptParamAdd()
    {
        var paramForShow = '';

        // variable param is being added to
        var paramValue = $('#dvs-param-value').val(); // input param value

        // value of param type when user submit create param form
        var paramTypeValue = $('#dvs-param-type').val();

        // format values according to param type
        if(paramTypeValue === 'params') {
            if(paramValue != ''){
                paramValue = 'params.' + paramValue;
            } else {
                paramValue = 'params';
            }
        } else if(paramTypeValue === 'input' && paramValue !== 'input') {
            if(paramValue != ''){
                paramValue = 'input.' + paramValue;
            } else {
                paramValue = 'input';
            }
        }

        paramForShow = paramValue; // keep a display version of param

        // wrap all params except boolean and static with { }
        if(paramTypeValue !== 'static') {
            paramValue = '{' + paramValue + '}';
        }

        // now add new param element to DOM by using the varName;
        // FYI: varName defined in admin/templates/params/create
       insertParamTemplateInDOM(varName, paramValue, paramForShow);
    }


    /**
     * Retrieves and updates single param template and
     * appends it to DOM.
     *
     * @param  {string} _varName  Name of variable to save to
     * @param  {string} _paramVal  Value of param text input, likely in "{ }"'s
     * @param  {string} _paramForShow  No curly wrapped param value
     * @return {void}
     */
    function insertParamTemplateInDOM(_varName, _paramVal, _paramForShow)
    {
        // the row where the add param click originated
        var varTableRow = $('tr#dvs-var-' + _varName);

        // the var type, "vars" or "newVars"
        var varType = $(varTableRow).data('var-type');

        // position of the last parameter div
        var lastParamDiv = $(varTableRow).find('> td div.dvs-param-wrapper:last');

        // retrive paramTemplate html and replace value placeholders
        var templateHtml = $(paramTemplate)
                                .html()
                                // .replace(/PARAM/g, _paramVal)
                                .replace('PARAM', _paramVal)
                                .replace('PARAM_FOR_SHOW', _paramForShow)
                                .replace('VAR_TYPE', varType)
                                .replace('VAR_NAME', _varName);

        // insert into DOM after last param value
        $(templateHtml).insertAfter(lastParamDiv);

        // remove modal and blocker
        $('#dvs-admin-modal').html('').addClass('dvs-hidden');
        $('#dvs-admin-blocker').addClass('dvs-hidden');
    }

    initialize();
});