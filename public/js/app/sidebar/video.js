devise.define(['require', 'jquery', 'dvsSidebarView', 'dvsLiveUpdate', 'dvsPageData', 'ckeditorJquery'], function (require, $, sidebar, liveUpdate, dvsPageData) {

    function onMediaManagerSelect(parentForm, video, target, settings)
    {
        var selector = 'input[name="' + target + '"]';

        parentForm.find(selector).val(video);

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
                var mediaUrl = url + '?type=video&target=' + target;

                document.onMediaManagerSelect = function(video, target, settings) { onMediaManagerSelect(parentForm, video, target, settings); }
                window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");
            });

             // init. live update functionality for video(s)
            $('form.dvs-element-video').each(function()
            {
                var parentForm = $(this);
                var videoPath = parentForm.find('input[name="video"]');

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, videoPath, 'video');
            });

        }
    };
});