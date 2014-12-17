define(['require', 'jquery', 'dvsLiveUpdate'], function (require, $, liveUpdate) {

    function applyMaxLength(maxlengthInput, textInput) {
        maxlengthInput.bind('input', function () {
            var val = $(this).val();
            if (val != '') {
                if (!isNaN(val)) {
                    $(this).val(parseInt(val));
                    textInput.attr('maxlength', parseInt(val));
                    if (textInput.val().length > val) {
                        // maxlength is shorter than current value cut off the extra characters
                        textInput.val(textInput.val().substring(0, val));
                    }
                } else {
                    var previousValue = val.substring(0, val.length - 1);
                    if (!isNaN(previousValue)) {
                        $(this).val(previousValue);
                    } else {
                        //something went wrong current maxlength
                        $(this).val(textInput.attr('maxlength'));
                    }
                }
            } else {
                //user trying to clear field current maxlength
                $(this).val(textInput.attr('maxlength'));
            }
        });
    }

    return {
        init: function() {
            $('form.dvs-element-textarea').each(function(){
                var parentForm = $(this);
                var textInput = parentForm.find('textarea[name="text"]');
                var maxlengthInput = parentForm.find('input[name="maxlength"]');

                applyMaxLength(maxlengthInput, textInput);

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, textInput, 'textarea');
            });
        }
    };
});