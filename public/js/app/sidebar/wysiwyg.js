define(['require', 'jquery', 'dvsSidebarView', 'ckeditorJquery'], function (require, $, sidebar) {

    function init()
    {
        var _config = {
            filebrowserBrowseUrl: '/admin/media-manager?type=image',
            filebrowserImageWindowWidth: '1024',
            filebrowserImageWindowHeight: '768',
            toolbar: [
                [ 'Source' ],
                [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo' ],
                [ 'Image', 'Table', 'Link' ],
                '/',
                [ 'FontSize', 'Bold', 'Italic', 'Underline', 'Strike' ],
                [ 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote' ]
            ]
        };

        var cke = $('textarea.dvs-wysiwyg').ckeditor(_config).editor;
    
        document.onMediaManagerSelect = function(funcNum, url){
            CKEDITOR.tools.callFunction(funcNum, url);
        };

        $('.dvs-fat-sidebar').click(function(){
            sidebar.fattenUp();
        });

        $('.dvs-skinny-sidebar').click(function(){
            sidebar.skinnyMe();
        });
    }

    $('#dvs-sidebar').on('sidebarLoaded', init);
    init();

});