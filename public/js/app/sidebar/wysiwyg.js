devise.define(['require', 'jquery', 'dvsSidebarView', 'dvsLiveUpdate', 'ckeditorJquery'], function (require, $, sidebar, liveUpdate) {
    return {
        init: function()
        {
            var _config = {
                filebrowserBrowseUrl: '/admin/media-manager?type=image',
                filebrowserImageWindowWidth: '1024',
                filebrowserImageWindowHeight: '768',
                toolbar: [
                    [ 'Source' ],
                    [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo' ],
                    [ 'Image', 'Table', 'Link', 'Iframe', 'HorizontalRule' ],
                    '/',
                    [ 'FontSize', 'Bold', 'Italic', 'Underline', 'Strike' ],
                    [ 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]
                ]
            };

            _config.extraPlugins = 'iframe,iframedialog,justify';

            var cke = $('textarea.dvs-wysiwyg').ckeditor(_config).editor;

            var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, cke, 'wysiwyg');

            document.onMediaManagerSelect = function(url, target, input){
                CKEDITOR.tools.callFunction(input.CKEditorFuncNum, url);
            };

            $('.dvs-fat-sidebar').click(function(){
                sidebar.fattenUp();
            });

            $('.dvs-skinny-sidebar').click(function(){
                sidebar.skinnyMe();
            });

        }
    };
});