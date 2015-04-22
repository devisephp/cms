devise.define(['require', 'jquery', 'ckeditorJquery'], function (require, $) {

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

            cke = $('textarea.dvs-wysiwyg').ckeditor(_config).editor;

            document.onMediaManagerSelect = function(url, target, input){
                CKEDITOR.tools.callFunction(input.CKEditorFuncNum, url);
            };

            $('.dvs-fat-sidebar').click(function(){
                console.log('need to fatten sidebar up here');
                // sidebar.fattenUp();
            });

            $('.dvs-skinny-sidebar').click(function(){
                console.log('need to skinny the sidebar');
                // sidebar.skinnyMe();
            });

            // updates the textarea input for us
            function updateInput(event)
            {
                cke.element.$.value = cke.getData();
                $(cke.element.$).trigger('input');
            }

            cke.on("instanceReady", function() {
                this.document.on('afterCommandExec', updateInput);
                this.document.on('afterRedo', updateInput);
                this.document.on('afterSetData', updateInput);
                this.document.on('afterUndo', updateInput);
                this.document.on('blur', updateInput);
                this.document.on('change', updateInput);
                this.document.on('click', updateInput);
                this.document.on('focus', updateInput);
                this.document.on('mouseover', updateInput);
                this.document.on('paste', updateInput);
                this.document.on('pasteDialog', updateInput);
                this.document.on("keyup", updateInput);
                this.document.on("paste", updateInput);
                this.document.on("keypress", updateInput);
            });
        }
    };
});