devise.define(['require', 'jquery', 'dvsLiveUpdate'], function (require, $, liveUpdate) {

    return {
        init: function() {
            $('form.dvs-element-html').each(function(){
                var parentForm = $(this);
                var htmlTextarea = parentForm.find('textarea[name="html"]');

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, htmlTextarea, 'html');
            });
        }
    };

});