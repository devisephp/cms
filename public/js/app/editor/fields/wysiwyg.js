devise.define(['require', 'jquery', 'ckeditorJquery'], function (require, $) {

    return {
        init: function()
        {
            // This retrieves an optional wysiwyg config override from the base-page.
            var wysiwygConfigFromPage = document.getElementById("dvs-iframe").contentWindow.wysiwygConfig;
            var wysiwygStylesFromPage = document.getElementById("dvs-iframe").contentWindow.wysiwygStyles;

            // Load any styles from the page into CKEditor
            for (var k in wysiwygStylesFromPage){
                if (wysiwygStylesFromPage.hasOwnProperty(k)) {
                     CKEDITOR.stylesSet.add( k, wysiwygStylesFromPage[k]);
                }
            }

            var _config = {
                filebrowserBrowseUrl: '/admin/media-manager?type=image',
                filebrowserImageWindowWidth: '1024',
                filebrowserImageWindowHeight: '768',
                allowedContent: true,
                enterMode: CKEDITOR.ENTER_BR, // pressing the ENTER Key puts the <br/> tag
                shiftEnterMode: CKEDITOR.ENTER_P, //pressing the SHIFT + ENTER Keys puts the <p> tag
                stylesSet: [ { name: 'Blue Title', element: 'p', attributes: { 'class': 'placeholder' }}],
                toolbar: [
                    [ 'Source' ],
                    [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo' ],
                    [ 'Image', 'Table', 'Link', 'Iframe', 'HorizontalRule', 'Span' ],
                    '/',
                    [ 'FontSize', 'Bold', 'Italic', 'Underline', 'Strike' ],
                    [ 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]
                ]
            };

            // Merge the overrides over the default
            for (var attrname in wysiwygConfigFromPage) { _config[attrname] = wysiwygConfigFromPage[attrname]; }

            _config.extraPlugins = 'iframe,iframedialog,justify,widget,image2,lineutils';
            _config.image2_captionedClass = 'image';

            cke = $('textarea.dvs-wysiwyg').ckeditor(_config).editor;

            document.onMediaManagerSelect = function(url, target, input){
                CKEDITOR.tools.callFunction(input.CKEditorFuncNum, url);
            };

            $('.dvs-fat-sidebar').click(function(){
                $("#dvs-sidebar-container").addClass('fat');
            });

            $('.dvs-skinny-sidebar').click(function(){
                $("#dvs-sidebar-container").removeClass('fat');
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