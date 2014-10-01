define(['require', 'jquery', 'dvsSidebarView', 'dvsLiveUpdate', 'ckeditorJquery'], function (require, $, sidebar, liveUpdate) {

    var video = {
        init: function() {
            $('.browse').click(function(){

                var parentForm = $(this).parents('form');
                var mediaUrl = '/admin/media-manager';

                var select = parentForm.find('select[name="cropMode"]');
                mediaUrl += '?cropMode=' + select.val();

                if(select.val() == 'Tool'){
                    mediaUrl += '&width=' + $('input[name="width"]').val();
                    mediaUrl += '&height=' + $('input[name="height"]').val();
                }

                window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");

                document.onMediaManagerSelect = function(videos){
                    parentForm.find('input[name="video"]').val(videos[0]);
                    try{
                        // @todo bug bug bug bombs when an video is already defined
                        parentForm.find('input[name="video"]').trigger('input');
                    } catch(e){

                    }
                };
            });

            // $('select[name="cropMode"').change(function(){
            //     var parentForm = $(this).parents('form');

            //     if($(this).val() == 'Preserve'){
            //         parentForm.find('.video-dims').hide();
            //     } else {
            //         parentForm.find('.video-dims').show();
            //     }
            // });

            // $('form.dvs-element-video').each(function () {

            //     var parentForm = $(this);
            //     var videoPath = parentForm.find('input[name="video"]');

            //     var _liveUpdate = liveUpdate.getInstance();
            //     _liveUpdate.init($, videoPath, 'video');
            // });
        }
    };

    $('#dvs-sidebar').on('sidebarLoaded', video.init);

    video.init();

});