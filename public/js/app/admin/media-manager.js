devise.define(['require', 'jquery', 'query'], function (require, $, query)
{
    var _input = {};
    return {
        init: function(input, finalImages)
        {
            _input = input;
            //
            // looks for all cropped images in url
            // if more than 1 found, the onMediaManagerSelect callback is triggered

            // If there is nobody that is currently owning "onMediaManagerSelect" then it's ckeditor
            if (opener && opener.document && (!opener.document.hasOwnProperty('onMediaManagerSelect') || opener.document.onMediaManagerSelect == null))  {

                opener.document.onMediaManagerSelect = function(images) {
                    var funcNum = getUrlParam( 'CKEditorFuncNum' );
                    var fileUrl = images;
                    window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );

                    opener.document.onMediaManagerSelect = null; // Let's null it out for the next guy

                    window.close();
                }
            }

            console.log('init!!!!', !opener.document.hasOwnProperty('onMediaManagerSelect'), opener.document.onMediaManagerSelect);

            // add the add categoryListener
            //
            $('#dvs-open-new-category').click(handleOpenNewCategory);

            //
            // add the image url
            // to the opener which has a function ready to go
            //
            $('.js-media-items').on('click', 'a.dvs-media-item', handleFileSelected);

            //
            // handle renaming and removing
            //
            $('.js-media-items').on('click', '.js-rename-item', handleFileRename);
            $('.js-media-items').on('click', '.js-remove-item', handleFileRemove);

            $('a.dvs-cat-delete-btn').click(handleCategoryRemove);
            $('a.dvs-cat-rename-btn').click(handleCategoryRename);

        }
    };

    function getUrlParam( paramName ) {
        var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
        var match = window.location.search.match( reParam );

        return ( match && match.length > 1 ) ? match[1] : null;
    }

    //
    // Opens the add new category form
    //
    function handleOpenNewCategory(e) {
        e.preventDefault();

        $(this).addClass('dvs-hidden');

        $('#dvs-new-category').removeClass('dvs-hidden');
    }

    //
    // When the file is selected we want to pass that file
    // back to the main opener document since this stuff
    // is all taking place inside of a popup window
    //
    function handleFileSelected(e)
    {
        e.preventDefault();

        var target = query.get('target');
        var url = $(this).attr('href');

        console.log(opener.document);

        opener.document.onMediaManagerSelect(url, target, _input);

        window.close();
    }

    //
    // Files are renamed using this javascript
    //
    function handleFileRename(e)
    {
        var element = $(e.currentTarget);
        var url = element.data('url');
        var filepath = element.data('filepath');
        var newpath = prompt('Where do you want to move this file to?', filepath);
        var data = {filepath: filepath, newpath: newpath};

        if (newpath)
        {
            $.ajax({
                method: 'put',
                url: url,
                data: data,
                success: function() { window.location.reload(); },
                error: function() { alert('Could not move this file!'); console.warn(arguments); }
            });
        }
    }

    //
    // Files are removed using this javascript
    //
    function handleFileRemove(e)
    {
        var element = $(e.currentTarget);
        var url = element.data('url');
        var confirmMessage = element.data('confirm');
        var filepath = element.data('filepath');
        var data = {filepath: filepath};

        if (confirm(confirmMessage))
        {
            $.ajax({
                method: 'delete',
                url: url,
                data: data,
                success: function() { window.location.reload(); },
                error: function() { alert('Cannot remove this file!'); console.warn(arguments); }
            });
        }
    }

    //
    // Categories are removed via this function
    //
    function handleCategoryRemove(evt)
    {
        if (confirm("Are you sure you want to delete this category and all it's files? This cannot be undone")){
            return true;
        } else {
            evt.preventDefault();
            return false;
        }
    }

    //
    // Categories are renamed via this function
    //
    function handleCategoryRename(e)
    {
        var element = $(e.currentTarget);
        var url = element.data('url');
        var name = element.data('name');
        var path = element.data('path');
        var newname = prompt('What is the new name of this category?', name);
        var data = {path: path, name: name, newname: newname};

        if (newname)
        {
            $.ajax({
                method: 'put',
                url: url,
                data: data,
                success: function() { window.location.reload(); },
                error: function() { alert('Could not rename this category!'); console.warn(arguments); }
            });
        }

        e.preventDefault();
        return false;
    }

});