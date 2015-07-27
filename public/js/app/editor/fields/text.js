devise.define(['require', 'jquery'], function (require, $) {

    var timeoutId = null;
    var textInput = null;

    return {
        init: function () {

            $('form.dvs-element-text').each(function () {

                var parentForm = $(this);
                textInput = parentForm.find('input[name="text"]');

            });
        }
    };
});