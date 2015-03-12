devise.define(['require', 'jquery', 'dvsSidebarView', 'dvsLiveUpdate', 'ckeditorJquery'], function (require, $, sidebar, liveUpdate) {

    // we pass the file and settings back from the
    // window opener. The target is the place we will
    // update, which is typically just file but could
    // be a thumbnail too
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
        init: function(url)
        {
            //
            // opens the media manager
            // so we can select a new file
            //
            $('.browse').click(function(e)
            {
                var parentForm = $(this).parents('form');
                var target = $(e.currentTarget).data('target');
                var mediaUrl = url + '?target=' + target;
                document.onMediaManagerSelect = function(file, target, settings) { onMediaManagerSelect(parentForm, file, target, settings); }
                window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");
            });

            // initializes live update of file input(s)
            $('form.dvs-element-file').each(function()
            {
                var parentForm = $(this);
                var filePath = parentForm.find('input[name="file"]');

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, filePath, 'file');
            });
        }
    };
});