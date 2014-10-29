define(['jquery', 'dvsListeners'], (function( $, listeners ) {

    var pageId = null;
    var pageVersionId = null;

    var initializeEditor = function (_pageId, _pageVersionId) {
        pageId = _pageId;
        pageVersionId = _pageVersionId;

        var deviseWrapper = buildDom();

        appendDom(deviseWrapper);
        appendControls();
        addEditorListeners();
        removePreloader();
    };

    function buildDom() {
        // @TODO "dvs-default" should set the theme of the admin.
        // This should be a configurable option in the initilization
        // of devise.

        /* General Structure of what we are adding:
         div#dvs-mode.[theme-class]
         -- div#dvs-container
         ---- div#dvs-pusher
         ------ div#dvs-content
         -------- (Original Body)
         */
        var theme = $('<div>').addClass('dvs-default').attr('id', 'dvs-mode');
        var container = $('<div>').attr('id', 'dvs-container');
        var pusher = $('<div>').attr('id', 'dvs-pusher');
        var content = $('<div>').attr('id', 'dvs-content');
        var blocker = $('<div>').attr('id', 'dvs-blocker');

        pusher.append(content);
        container.append(pusher);
        theme.append(container);

        return theme;
    }

    function appendDom(wrapper) {
        $('body').wrapInner(wrapper);
        $('#dvs-mode').data('dvs-page-id', pageId);
        $('#dvs-mode').data('dvs-page-version-id', pageVersionId);
    }

    function appendControls() {
        var theme       = $('#dvs-mode');
        var content     = $('#dvs-content');
        var shadow      = $('<div>').attr('id', 'dvs-content-edit-shadow');
        var editButton  = $('<button>').attr('id', 'dvs-node-mode-button').html('Edit Page');
        var adminButton = $('<button>').attr({id: 'dvs-admin-mode-button', onClick: 'location.href = "/admin/pages"'}).html('Admin');

        var nodes       = $('<div>').attr('id', 'dvs-nodes').addClass('dvs-faded');
        var sidebar     = $('<div>').attr('id', 'dvs-sidebar');

        content.append(shadow);
        theme.append(editButton);
        theme.append(adminButton);
        theme.append(nodes);
        theme.append(sidebar);

//        $('#dvs-nodes').removeClass('dvs-faded');
    }

    function addEditorListeners() {
        listeners.addEditorListeners();
    }

    function removePreloader() {
        // Removes class disabling animation on page load
        $("body").removeClass("preload");
    }

    return initializeEditor;

}));