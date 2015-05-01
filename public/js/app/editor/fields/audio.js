devise.define(['jquery'], function ($) {

    function onMediaManagerSelect(parentForm, file, target, settings)
    {
        var selector = 'input[name="' + target + '"]';

        parentForm.find(selector).val(file);

        // make sure to trigger the change on this input
        // in case we have any events tied to that element
        parentForm.find(selector).trigger('input');
        parentForm.find(selector).trigger('propertychange');
    }

    return {
        init: function(url) {
            $('.browse').click(function(e)
            {
                var parentForm = $(this).parents('form');
                var target = $(e.currentTarget).data('target');
                var mediaUrl = url + '?type=audio&target=' + target;

                document.onMediaManagerSelect = function(file, target, settings) { onMediaManagerSelect(parentForm, file, target, settings); }
                window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");
            });
        }
    };

});