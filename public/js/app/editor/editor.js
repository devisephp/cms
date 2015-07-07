devise.define(['jquery', 'query', 'dvsSidebarView', 'dvsBaseView', 'dvsPositionHelper', 'dvsSelectSurrogate', 'dvsLiveUpdater', 'BindingsFinder'], function($, query, Sidebar, View, dvsPosition, dvsSelectSurrogate, LiveUpdater, BindingsFinder)
{
    var events = {
        'click #dvs-node-mode-button': onNodeModeButtonClicked,
        'click #dvs-about-page-button': onAboutPageButtonClicked,
        'click #dvs-about-page-container h5': onAboutPageVariableClicked,
        'click .dvs-sidebar-close': onCloseSidebarButtonClicked
    };

    /**
     * The editor class we are building
     */
    var Editor = function (templates, data, csrf)
    {
        this.events = events;
        this.csrf = csrf;
        this.sidebar = new Sidebar(data);
        this.updateData(data);
    }

    /**
     * Updates the page data for this and sidebar.page
     */
   Editor.prototype.updateData = function (data)
    {
        this.pageId = data.pageId;
        this.pageVersionId = data.pageVersionId;
        this.data = data;
        this.sidebar.page = data;
    }

    /**
     * Start the editor, this is how things get rolling
     */
    Editor.prototype.start = function()
    {
        if (! this.shouldStart()) return false;

        this.removeParentStyles();

        this.render();

        View.registerEvents(this.layoutView, this.events, this);

        $('body').show();

        return true;
    }

    /**
     * Removes all non-devise styles from parent page
     * to keep them from overriding our stuff on the parent.
     * This has the effect of sandboxing page specific
     * styles inside of the dvs-iframe. We will try and keep
     * our styles out of the sandboxed iframe.
     */
    Editor.prototype.removeParentStyles = function()
    {
        $('link[rel="stylesheet"], style').each(function(index, element)
        {
            var el = $(element);

            if (typeof el.data('deviseEditorAsset') === 'undefined')
            {
                el.remove();
            }
        });
    }

    /**
     * render the editor layout
     */
    Editor.prototype.render = function()
    {
        this.layoutView             = $('#dvs-mode');
        this.iframeView             = this.layoutView.find('#dvs-iframe');
        this.nodesView              = $('<div/>');
        this.iframeBodyView         = $('<div/>');
        this.editButtonView         = this.layoutView.find('#dvs-node-mode-button');
        this.aboutPageButtonView    = this.layoutView.find('#dvs-about-page-button');
        this.aboutPageContainerView = this.layoutView.find('#dvs-about-page-container');
        this.sidebarContainerView   = this.layoutView.find('#dvs-sidebar-container');
        this.sidebarView            = this.layoutView.find('#dvs-sidebar');

        loadEditorIframe(this);

        this.aboutPageContainerView.empty();
        this.aboutPageContainerView.append(View.make('about-page'));
    }

    /**
     * Creates all the nodes in the nodes view
     */
    Editor.prototype.createNodesView = function()
    {
        var nodesView = $('<div id="dvs-nodes" style="width: 100%; position: absolute; top: 0px; left: 0px;"; class="dvs-faded"></div>');
        var editor = this;

        $.each(this.data.nodes, function(index, node)
        {
            var nodeView = View.make('editor.node', {id: node.cid + '-node', cid: index, node: node});

            if (node.data.content_requested == 1) {
                nodeView.addClass('dvs-content-requested');
            }

            nodesView.append(nodeView);
        });

        // register handler for clicking on a node
        // this should show the sidebar for that node
        nodesView.on('click', '[data-node-cid]', function(event)
        {
            var cid = $(event.currentTarget).data('node-cid');
            editor.showSidebar(cid);
        });

        return nodesView;
    }

    /**
     * Since we are cloning the page inside of an iframe
     * we don't want to get an infinite loop of iframes trying
     * to include the same page over and over. We use the
     * start-editor parameter to keep that from happening.
     */
    Editor.prototype.shouldStart = function()
    {
        return location.href.indexOf('start-editor=false') === -1
        && location.href.indexOf('disable-editor') === -1;
    }

    /**
     * Show the editor
     */
    Editor.prototype.showEditor = function()
    {
        this.layoutView.addClass('dvs-node-mode');
        this.iframeBodyView.addClass('dvs-node-mode');
        this.showingEditor = true;
        this.nodesView.show();
    }

    /**
     * Hide the editor
     */
    Editor.prototype.hideEditor = function()
    {
        this.nodesView.hide();
        this.showingEditor = false;
        this.layoutView.removeClass('dvs-node-mode');
        this.iframeBodyView.removeClass('dvs-node-mode');
    }

    /**
     * Show the sidebar for the node with the given cid
     */
    Editor.prototype.showSidebar = function(cid)
    {
        var node = this.data.nodes[cid];

        this.hideEditor();

        this.showingSidebar = true;
        this.sidebarView.empty();
        this.sidebarView.append(this.sidebar.render(node));
        this.sidebarView.addClass('loaded');
        this.layoutView.addClass('dvs-sidebar-mode');
        this.iframeBodyView.addClass('dvs-sidebar-mode');
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
        this.showingSidebar = false;
        this.sidebar.close();
        this.sidebarContainerView.hide();
        this.sidebarView.removeClass('loaded');
        this.layoutView.removeClass('dvs-sidebar-mode');
        this.iframeBodyView.removeClass('dvs-sidebar-mode');
        this.sidebarView.empty();
        this.showEditor();
    }

    /**
     * Recalulates the positions for all the nodes
     * that get shown on the page
     */
    Editor.prototype.recalculateNodePositions = function()
    {
        dvsPosition.recalculateNodePositions(this.nodesView, this.data.nodes);
    }

    /**
     * Resets the iframe height once it is loaded...
     */
    function loadEditorIframe(editor)
    {
        var iframe = editor.iframeView;

        iframe.load(function()
        {
            var contentWindow = this.contentWindow;

            setTimeout(function()
            {
                var url = contentWindow.location.href;

                // if you find the url has been reloaded to
                // something that doesn't have start-editor in it, then
                // reload this page's url to iframe's url
                if (url.indexOf('start-editor=false') === -1)
                {
                    window.location.href = url;
                    return;
                }

                // give all <a> tags a target to the top parent frame
                // if new <a> links are added later via javascript
                // the start-editor=false redirect (see above) will
                // catch it
                iframe.contents().find('a').each(function(index, el){
                    $(el).attr('target', '_top');
                });

                // check for form submissions, and when we find one
                // we actually take the form out of the iframe, and submit
                // it via the parent frame, so that it won't be submitted
                // inside of the iframe...
                var body = iframe.contents().find('body');

                body.on('submit', 'form', function(e)
                {
                    e.preventDefault();
                });

                // in case the iframe is reloaded, we need to check for these
                // classes for the nodes to show up properly
                if (editor.showingSidebar) body.addClass('dvs-sidebar-mode');
                if (editor.showingEditor) body.addClass('dvs-node-mode');

                // copy over the database fields for live updates
                editor.updateData(contentWindow.dvsPageData);

                // update csrfToken
                editor.csrf(editor.data.csrfToken);

                // create a finder on this editor
                editor.finder = new BindingsFinder(editor.data.database)

                // find all the bindings
                editor.bindings = editor.finder.find(getRootHtmlNode(contentWindow.document.childNodes));

                // apply the bindings now
                editor.bindings.apply();

                // put the nodes inside of the iframe body
                body.append(editor.createNodesView());
                editor.iframeBodyView = body;
                editor.nodesView = body.find('#dvs-nodes');
                editor.recalculateNodePositions();

                // sets the iframe up so we can control it's content
                LiveUpdater.setup(iframe, editor.bindings, editor.data.database);
            });
        });

        iframe.attr('src', query.append('start-editor', 'false', location.origin + location.pathname + location.search)  + location.hash);
    }

    /**
     * Finds the html node inside of this array of nodes
     */
    function getRootHtmlNode(nodes)
    {
        for (var i = 0; i < nodes.length; i++)
        {
            if (nodes[i].nodeType === 1)
            {
                return nodes[i];
            }
        }

        return null;
    }

    /**
     *  handle the edit button being clicked
     *  we basically just show the node view
     */
    function onNodeModeButtonClicked(event)
    {
        var shown = (this.layoutView.hasClass('dvs-node-mode'))
            ? this.hideEditor()
            :this.showEditor();
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
     * handle when the about page button is clicked
     */
    function onAboutPageButtonClicked(event)
    {
        this.aboutPageButtonView.toggleClass('open');
        this.aboutPageContainerView.toggleClass('open');
    }

    /**
     * handle when variables clicked
     */
    function onAboutPageVariableClicked(event)
    {
        $(event.currentTarget).siblings('.about-var-dump').toggleClass('open');
    }

    /**
     * Returns this class, we still have to initialize it
     */
    return Editor;
});