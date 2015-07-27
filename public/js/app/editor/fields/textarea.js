devise.define(['require', 'jquery'], function (require, $) {

    return {
        init: function() {
            $('form.dvs-element-textarea').each(function(){
                var parentForm = $(this);
                var textInput = parentForm.find('textarea[name="text"]');
            });
        }
    };

});