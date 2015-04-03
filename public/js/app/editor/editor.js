devise.define(['jquery', 'query', 'dvsSidebarView', 'dvsBaseView', 'dvsPositionHelper', 'dvsSelectSurrogate'], function($, query, Sidebar, View, dvsPosition, dvsSelectSurrogate)
{
    var events = {
        'click #dvs-node-mode-button': onClickNodeModeButton,
        'click [data-node-cid]': onNodeButtonClicked,
        'click .dvs-sidebar-close': onCloseSidebarButtonClicked,
        'click #dvs-sidebar-add-version': onAddPageVersionBtnClicked,
    };

    /**
     * The editor class we are building
     */
    var Editor = function (templates, data)
    {
        this.pageId = data.pageId;
        this.pageVersionId = data.pageVersionId;
        this.events = events;
        this.data = data;
        this.sidebar = new Sidebar(data);
    }

    /**
     * Start the editor, this is how things get rolling
     */
    Editor.prototype.start = function()
    {
        if (! this.shouldStart()) return false;

        var wrapper = createDeviseWrapper();

        var page = wrapPageInsideDeviseWrapper(wrapper);

        registerViews(this, page);

        registerEvents(this, page);

        initializeNodesView(this.data.nodes, this.nodesView, this);

        return true;
    }

    /**
     * Since we are cloning the page inside of an iframe
     * we don't want to get an infinite loop of iframes trying
     * to include the same page over and over. We use the
     * start-editor parameter to keep that from happening.
     */
    Editor.prototype.shouldStart = function()
    {
        return location.href.indexOf('start-editor=false') === -1;
    }

    /**
     * Show the editor
     */
    Editor.prototype.showEditor = function()
    {
        this.view.addClass('dvs-node-mode');
        this.nodesView.show();
    }

    /**
     * Hide the editor
     */
    Editor.prototype.hideEditor = function()
    {
        this.nodesView.hide();
        this.view.removeClass('dvs-node-mode');
    }

    /**
     * Show the sidebar for the node with the given cid
     */
    Editor.prototype.showSidebar = function(cid)
    {
        var node = this.data.nodes[cid];

        this.hideEditor();

        this.sidebarView.empty();
        this.sidebarView.append(this.sidebar.render(node));
        this.sidebarView.addClass('loaded');
        this.view.addClass('dvs-sidebar-mode');
        this.sidebarContainerView.show();
        this.sidebarRendered(node);
    }

    /**
     * Run these commands after the sidebar is shown
     */
    Editor.prototype.sidebarRendered = function(node)
    {
        dvsSelectSurrogate();
    }

    /**
     * Hide the sidebar view
     */
    Editor.prototype.hideSidebar = function()
    {
        this.sidebar.close();
        this.sidebarContainerView.hide();
        this.sidebarView.removeClass('loaded');
        this.view.removeClass('dvs-sidebar-mode');
        this.sidebarView.empty();
        this.showEditor();
    }

    /**
     * Recalulates the positions for all the nodes
     * that get shown on the page
     */
    Editor.prototype.recalculateNodePositions = function()
    {
        dvsPosition.recalculateNodePositions(this);
    }

    /**
     * Adds page version to this page
     */
    Editor.prototype.addPageVersion = function(name)
    {
       var data = { page_version_id: this.pageVersionId, name: name };

        $.post('/admin/page-versions', data).then(function(results, status, xhr)
        {
            var href = window.location.origin; // base url of current page
            href += window.location.pathname; // add on current subpage(s)
            href += '?page_version=' + results.name; // add on new page version params
            window.location.href = href;
        });
    }

    /**
     * Saves a node to database and updates our local cache when
     * things return
     */
     Editor.prototype.persist = function(node)
     {
        var defer = new $.Deferred;

        console.log('persisting node', node);

        defer.promise;
     }

    /**
     * create the devise wrapper that wraps the current page
     */
    function createDeviseWrapper()
    {
        var theme = $('<div class="dvs-default" id="dvs-mode">');
        var container = $('<div id="dvs-container">');
        var pusher = $('<div id="dvs-pusher">');
        var content = $('<div id="dvs-content">');
        var iframe      = $('<iframe id="dvs-iframe" scrolling="no" style="width: 100%; pointer-events: none; opacity: 0.8;">');

        var editButton  = $('<button id="dvs-node-mode-button">').html('Edit Page');
        var adminButton = $('<button id="dvs-admin-mode-button" onclick="location.href = \'/admin/pages\'">').html('Admin');

        var nodes       = $('<div id="dvs-nodes" class="dvs-faded">');
        var sidebarContainer = $('<div id="dvs-sidebar-container" style="display: none;">');
        var sidebarScroll = $('<div id="dvs-sidebar-scroller">');
        var sidebar     = $('<div id="dvs-sidebar">');

        resetDvsIframeHeight(iframe);
        iframe.attr('src', query.append('start-editor', 'false', location.href));

        container.append(pusher);

        pusher.append(content);
        pusher.append(iframe);

        sidebarContainer.append(sidebarScroll);
        sidebarScroll.append(sidebar);

        theme.append(container);
        theme.append(editButton);
        theme.append(adminButton);
        theme.append(nodes);
        theme.append(sidebarContainer);

        return theme;
    }

    /**
     * Gets all the views setup correctly, now that our
     * page is wrapped and bootstraped
     */
    function registerViews(editor, page)
    {
        editor.view                   = page.find('#dvs-mode');
        editor.containerView          = page.find('#dvs-container');
        editor.pusherView             = page.find('#dvs-pusher');
        editor.contentView            = page.find('#dvs-content');
        editor.iframeView             = page.find('#dvs-iframe');
        editor.editButtonView         = page.find('#dvs-node-mode-button');
        editor.adminButtonView        = page.find('#dvs-admin-mode-button');
        editor.nodesView              = page.find('#dvs-nodes');
        editor.sidebarContainerView   = page.find('#dvs-sidebar-container');
        editor.sidebarScrollView      = page.find('#dvs-sidebar-scroller');
        editor.sidebarView            = page.find('#dvs-sidebar');
    }

    /**
     * Registers all the events on this page
     */
    function registerEvents(editor, page)
    {
        View.registerEvents(page, editor.events, editor);
    }

    /**
     * Creates the nodes inside this nodes element
     */
    function initializeNodesView(nodes, nodesView, editor)
    {
        $.each(nodes, function(index, node)
        {
            var nodeView = View.make('editor.node', {cid: index, node: node});
            nodesView.append(nodeView);
        });

        editor.recalculateNodePositions();
    }

    /**
     * wraps the body inside of this devise wrapper
     */
    function wrapPageInsideDeviseWrapper(wrapper)
    {
        var body = $('body');
        var paddingTop = parseInt(body.css('padding-top'));
        var paddingBot = parseInt(body.css('padding-bottom'));
        var documentHeight = $(document).height() + paddingTop + paddingBot;

        body.attr('style', ' height:' + documentHeight + 'px!important;');
        body.wrapInner(wrapper);

        return body;
    }

    /**
     * Resets the iframe height once it is loaded...
     */
    function resetDvsIframeHeight(iframe)
    {
        iframe.load(function() {
            var self = this;
            setTimeout(function() {
                self.style.height = self.contentWindow.document.body.offsetHeight + 'px';
                self.style.display = 'none';
            }, 50);
        });
    }

    /**
     *  handle the edit button being clicked
     *  we basically just show the node view
     */
    function onClickNodeModeButton(event)
    {
        var shown = (this.view.hasClass('dvs-node-mode'))
            ? this.hideEditor()
            :this.showEditor();
    }

    /**
     * handle when the node button is clicked
     * we need to show the sidebar for this
     * node
     */
    function onNodeButtonClicked(event)
    {
        var cid = $(event.currentTarget).data('node-cid');
        this.showSidebar(cid);
    }

    /**
     * handle whenever the sidebar button is closed
     */
    function onCloseSidebarButtonClicked(event)
    {
        this.hideSidebar();
        this.showEditor();
    }

    /**
     * handle when the add page version button is clicked
     */
    function onAddPageVersionBtnClicked(event)
    {
        var pageName = prompt('What would you like to name this new page version?');

        if (pageName) this.addPageVersion(pageName);
    }

    /**
     * handle when the save button is clicked in the sidebar
     */
    function onSidebarSaveButtonClicked(event)
    {
        this.sidebar.persist(this.editingNode);
    }

    /**
     * Returns this class, we still have to initialize it
     */
    return Editor;
});