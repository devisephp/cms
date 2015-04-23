devise.define(['require', 'jquery', 'dvsLiveUpdate'], function (require, $, liveUpdate) {
    return {
        init: function() {
            $('form.dvs-element-link').each(function () {

                var parentForm = $(this);
                var textInput = parentForm.find('input[name="text"]');

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, textInput, 'link');
            });
        }

    };
});