devise.define(['require', 'jquery'], function (require, $) {


    var timeoutId = null;
    var maxLengthValue = null;
    var maxlengthInput = null;
    var textInput = null;

    function addMaxLengthInputBinding() {
        maxlengthInput.bind('keyup', function () {
            
            clearUpdateTimeout();
            
            maxLengthValue = $(this).val();
                        
            if (maxLengthValue !== '' && !isNaN(maxLengthValue)) {
                timeoutId = window.setTimeout(updateTextInput, 1000);
            } 
        });
    }

    function updateTextInput() {
        textInput.attr('maxlength', parseInt(maxLengthValue));
        if (textInput.val().length > maxLengthValue) {
            // maxlength is shorter than current maxLengthValue cut off the extra characters
            textInput.val(textInput.val().substring(0, maxLengthValue));
        }
    }

    function clearUpdateTimeout() {
        window.clearTimeout(timeoutId);
    }

    return {
        init: function () {

            $('form.dvs-element-text').each(function () {

                var parentForm = $(this);
                textInput = parentForm.find('input[name="text"]');
                maxlengthInput = parentForm.find('input[name="maxlength"]');

                addMaxLengthInputBinding();
            });
        }
    };
});