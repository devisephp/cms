devise.define(['jquery', 'scrollTo'], function($) {

    var expandContractDocs = function() {
        if ($('#devise-documentation-container').hasClass('dvs-expanded')){
            $('#devise-documentation-container').removeClass('dvs-expanded');
            $('#dvs-docs-expand').html('&#10095;');
        } else {
            $('#devise-documentation-container').addClass('dvs-expanded');
            $('#dvs-docs-expand').html('&#10094;');
        }
    };

    var closeDocs = function()
    {
        $('#devise-documentation-container').addClass('dvs-closed');
    };

    var openDocs = function(el)
    {
        var target = slugifyString($(this).data('dvs-document'));

        $('#devise-documentation-container').removeClass('dvs-closed');
        $('#dvs-docs-inner-contents').scrollTo( '#' + target, 800 );
    };

    var toggleToc = function()
    {
        if ($('#dvs-docs-toc').hasClass('dvs-hidden')) {
            $('#dvs-docs-toc').removeClass('dvs-hidden');
        } else {
            $('#dvs-docs-toc').addClass('dvs-hidden');
        }
    };

    var addExpandContractListner = function()
    {
        $('#dvs-docs-expand').click(expandContractDocs);
    };

    var addCloseListener = function()
    {
        $('#dvs-docs-close').click(closeDocs);
    };

    var addOpenListener = function()
    {
        $('.dvs-document').click(openDocs);
    };

    var addTocListener = function()
    {
        $('#dvs-docs-toc-expand').click(toggleToc);
    }

    var addInlineAnchors = function()
    {
        $('#devise-documentation-container h3').each(function(){
            var title = $(this).html();
            var slug = slugifyString(title);

            $( '<a id="' + slug + '">#</a> ' ).prependTo(this);
            $( '<li><a href="#' + slug + '">' + title + '</a></li>' ).appendTo('#dvs-docs-toc');
        });
    };

    var slugifyString = function(str)
    {
        str = str.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-');        // Replace multiple - with single -

        return str.trim();
    };

    return {
        init: function()
        {
            addInlineAnchors();
            addExpandContractListner();
            addOpenListener();
            addCloseListener();
            addTocListener();
        }
    };

});
