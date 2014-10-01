define(['require', 'jquery', 'dvsLiveUpdate'], function (require, $, liveUpdate) {
    var link = {
        init: function() {
            $('form.dvs-element-link').each(function () {

                var parentForm = $(this);
                var textInput = parentForm.find('input[name="text"]');

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, textInput, 'link');
            });
        }

    };

    return link;
});