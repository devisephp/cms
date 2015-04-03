devise.define(['jquery', 'dvsListeners'], (function( $, listeners ) {

    var pageId = null;
    var pageVersionId = null;

    var initializeEditor = function (_pageId, _pageVersionId) {
        if (location.search.indexOf('preview-only=true') !== -1) return;

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

        // Get all the styles from the body tag
        // var bodyStyles = css($('body'));

        /* General Structure of what we are adding:
         div#dvs-mode.[theme-class]
         -- div#dvs-container
         ---- div#dvs-pusher
         ------ div#dvs-content
         -------- (Original Body)
         */
        var theme = $('<div>').addClass('dvs-default').attr('id', 'dvs-mode');
        var container = $('<div">').attr('id', 'dvs-container');
        var pusher = $('<div>').attr('id', 'dvs-pusher');
        var content = $('<div>').attr('id', 'dvs-content');
        var iframe      = $('<iframe scrolling="no" style="width: 100%; pointer-events: none; opacity: 0.8;">').attr('id', 'dvs-iframe');

        pusher.append(content);
        pusher.append(iframe);
        container.append(pusher);
        theme.append(container);

        iframe.load(function() {
            var self = this;
            setTimeout(function() {
                $('body').fadeIn();
                self.style.height = self.contentWindow.document.body.offsetHeight + 'px';
                self.style.display = 'none';
            }, 50);
        });

        iframe.attr('src', location.href + '?preview-only=true')

        return theme;
    }

    function appendDom(wrapper) {

        var _body = $('body');
        var _paddingTop = parseInt(_body.css('padding-top'));
        var _paddingBot = parseInt(_body.css('padding-bottom'));
        var _documentHeight = $(document).height() + _paddingTop + _paddingBot;

        if (_body.height() < _documentHeight) {
            _body.attr(
                'style',
                ' height:' + _documentHeight + 'px!important; '
            );
        }

        _body.wrapInner(wrapper);
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
        var sidebarCont = $('<div>').attr('id', 'dvs-sidebar-container').attr('style', 'display:none;');
        var sidebarScroll = $('<div>').attr('id', 'dvs-sidebar-scroller');
        var sidebar     = $('<div>').attr('id', 'dvs-sidebar');

        theme.append(editButton);
        theme.append(adminButton);
        theme.append(nodes);

        sidebarCont.append(sidebarScroll);
        sidebarScroll.append(sidebar);
        theme.append(sidebarCont);
    }

    function addEditorListeners() {
        listeners.addEditorListeners();
    }

    function removePreloader() {
        // Removes class disabling animation on page load
        $("body").removeClass("preload");
    }

    function css(a) {
        var sheets = document.styleSheets, o = {};
        for (var i in sheets) {
            var rules = sheets[i].rules || sheets[i].cssRules;
            for (var r in rules) {
                if (a.is(rules[r].selectorText)) {
                    o = $.extend(o, css2json(rules[r].style), css2json(a.attr('style')));
                }
            }
        }
        return o;
    }

    function css2json(css) {
        var s = {};
        if (!css) return s;
        if (css instanceof CSSStyleDeclaration) {
            for (var i in css) {
                if ((css[i]).toLowerCase) {
                    if(css[i] !== "overflow-x" && css[i] !== 'overflow-y') {
                        s[(css[i]).toLowerCase()] = (css[css[i]]);
                    }
                }
            }
        } else if (typeof css == "string") {
            css = css.split("; ");
            for (var i in css) {
                var l = css[i].split(": ");
                s[l[0].toLowerCase()] = (l[1]);
            }
        }
        return s;
    }

    return initializeEditor;

}));