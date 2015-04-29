devise.define(['jquery', 'scrollTo', 'localScroll'], function($) {

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

    var openDocs = function()
    {
        var docTarget = $(this).data('dvs-document');
        $('#devise-documentation-container').removeClass('dvs-closed');

        if (typeof docTarget !== 'undefined') {
            var target = slugifyString(docTarget);
            $('#dvs-docs-inner-contents').scrollTo( '#' + target, 800 );
        }
    };

    var toggleToc = function(e)
    {
        e.preventDefault();

        if ($('#dvs-docs-toc').hasClass('dvs-hidden')) {
            $('#dvs-docs-toc-expand > .dvs-toc-arrow').addClass('down');
            $('#dvs-docs-toc').removeClass('dvs-hidden');
        } else {
            $('#dvs-docs-toc').addClass('dvs-hidden');
            $('#dvs-docs-toc-expand > .dvs-toc-arrow').removeClass('down');
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
        $('[data-dvs-document]').click(openDocs);
    };

    var addTocListener = function()
    {
        $('#dvs-docs-toc-expand').click(toggleToc);
    };

    var addTocScrollTos = function()
    {
        $.localScroll({
            target: '#dvs-docs-inner-contents'
        });
    };

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
        init: function(show)
        {
            addInlineAnchors();
            addExpandContractListner();
            addOpenListener();
            addCloseListener();
            addTocListener();
            addTocScrollTos();

            //if (show === 'true') {
                openDocs();
            //}
        }
    };

});
