(function () {
devise.define('dvsTemplates',['jquery', 'handlebars'], function($, handlebars)
{
	/**
	 * store templates in this object
	 */
	var templates = { JST: {} };

	/**
	 * make a new view given viewpath and data
	 */
	templates.make = function(viewpath, data)
	{
		if (typeof this.JST[viewpath] === 'undefined')
		{
			this.register(viewpath);
		}

		if (typeof this.JST[viewpath] === 'undefined')
		{
			throw viewpath + ' is not a registered template!';
		}

		if (typeof this.JST[viewpath] !== 'function')
		{
			this.JST[viewpath] = handlebars.compile(this.JST[viewpath]);
		}

		return this.JST[viewpath](data);
	};

	/**
	 * registers a new view to be cached
	 */
	templates.register = function(viewpath)
	{
		var html =  $('script[id="' + viewpath + '"]').html();
		this.JST[viewpath] = html;
	}

	/**
	 * register helper for when
	 */
	handlebars.registerHelper('when', function(value, option1, option2) {
		if (value && value != '0' && value != 'false') return option1;

		if (typeof option2 !== 'string') return '';

		return option2;
	});

	/**
	 * register helper for get
	 */
	handlebars.registerHelper('get', function(value, defaultValue) {
		if (value) return value;

		return defaultValue;
	});

	/**
	 * register helper for date formatting
	 */
	handlebars.registerHelper('date', function(currentTime, dateFormat) {
		var date = new Date;

		if (typeof currentTime !== 'undefined' && currentTime !== 'now' && currentTime !== '' && currentTime != false) {
			date = new Date(currentTime);
		}

		if (typeof dateFormat === 'undefined' || dateFormat === '') {
			dateFormat = 'm/d/Y';
		}

		return date.dateFormat(dateFormat);
	});

	/**
	 * register helper for datetime formatting
	 */
	handlebars.registerHelper('datetime', function(currentTime, dateFormat) {
		var date = new Date;

		if (typeof currentTime !== 'undefined' && currentTime !== 'now' && currentTime !== '' && currentTime != false) {
			date = new Date(currentTime);
		}

		if (typeof dateFormat === 'undefined' || dateFormat === '') {
			dateFormat = 'm/d/Y h:i A';
		}

		return date.dateFormat(dateFormat);
	});

	/**
	 * register helper for select
	 */
	handlebars.registerHelper("select", function(value, defaultValue, options) {

		if (typeof options === 'undefined') {
			options = defaultValue;
		} else if (!value) {
			value = defaultValue;
		}

		return options.fn(this).split('\n').map(function(v) {
			var t = 'value="' + value + '"'
			return ! RegExp(t).test(v) ? v : v.replace(t, t + ' selected="selected"')
		}).join('\n')
	});

	/**
	 * register helper for ifType
	 */
	handlebars.registerHelper("ifType", function(object, type, options) {
		if (typeof object === type) {
			return options.fn(this);
		} else {
			return options.inverse(this);
		}
	});

	/**
	 * register helper for checked
	 */
	handlebars.registerHelper("checked", function(value, options) {
		return value && value != '0' && value != 'false' ? 'checked' : '';
	});

	/**
	 * register helper for disabled
	 */
	handlebars.registerHelper("disabled", function(value, options) {
		return value && value != '0' && value != 'false' ? 'disabled' : '';
	});

	/**
	 * register helper for scripts
	 */
	handlebars.registerHelper("script", function(options) {
		if (options.fn)
			return '<script>' + options.fn(this) + '</script>';

		if (options.hash.src) {
			console.log(options.hash.src);
			return '<script src="'+ options.hash.src +'"></script>';
		}
	});



	/**
	 * return the templates object
	 */
	return templates;
});
devise.define('dvsEditor',['jquery', 'query', 'dvsSidebarView', 'dvsBaseView', 'dvsPositionHelper', 'dvsSelectSurrogate', 'dvsLiveUpdater', 'BindingsFinder'], function($, query, Sidebar, View, dvsPosition, dvsSelectSurrogate, LiveUpdater, BindingsFinder)
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
                    var attr = $(this).attr('target');
                    if (typeof attr == typeof undefined || attr == '_self') {
                        $(el).attr('target', '_top');
                    }
                });

                // check for form submissions, and when we find one
                // we actually take the form out of the iframe, and submit
                // it via the parent frame, so that it won't be submitted
                // inside of the iframe...
                var body = iframe.contents().find('body');

                body.on('submit', 'form', function(e)
                {
                    if (!$(e.currentTarget).hasClass('dvs-allow-submit')) e.preventDefault();
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

        var origin = location.origin;

        if (!window.location.origin)
        {
            origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
        }

        iframe.attr('src', query.append('start-editor', 'false', origin + location.pathname + location.search)  + location.hash);
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
devise.define('query',['jquery'], (function($)
{
    var query = {};

    /**
     * Get the string as a json data object
     */
    query.toJson = function(string)
    {
        if (typeof string === 'undefined') {
            string = window.location.search.substr(1);
        }

        var a = string.split('&');
        var b = {};

        if (a == "") return {};

        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=', 2);

            if (p.length == 1) b[p[0]] = "";
            else b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }

        return b;
    };

    /**
     * Get the json data as a query string
     */
    query.toQueryString = function(jsonData)
    {
        if (typeof jsonData === 'undefined') jsonData = {};

        var params = '';

        $.each(jsonData, function(index, element) {
            params += '&' + index + '=' + encodeURIComponent(element);
        });

        return params.replace('&', '?');
    };

    /**
     * Get the parameter by name
     */
    query.get = function(name, defaults)
    {
        defaults = (typeof defaults === 'undefined') ? null : defaults;
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);

        return results == null ? defaults : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    /**
     * Append this name, value pair onto the end of this url
     */
    query.append = function(name, value, url)
    {
        var prefix = url.indexOf('?') === -1 ? '?' : '&';

        return url + prefix + name + '=' + encodeURIComponent(value);
    }

    return query;
}));

devise.define('dvsCsrf',['jquery'], function ($)
{
	function updateToken(token)
	{
	    $.ajaxSetup({
	        headers: {
	            'X-XSRF-TOKEN': token
	        }
	    });
	}

	var csrfToken = $('meta[name="csrf-token"]').attr('content');

	if (csrfToken) updateToken(csrfToken);

    return updateToken;
});
devise.define('dvsSidebarView',['jquery', 'query', 'dvsBaseView', 'dvsFieldView', 'dvsCollectionView', 'dvsModelView', 'dvsAttributeView', 'dvsCreatorView', 'dvsGroupView', 'dvsBreadCrumbsView', 'jqSerializeObject'], function($, query, View, FieldView, CollectionView, ModelView, AttributeView, CreatorView, GroupView, BreadCrumbsView)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'change #dvs-sidebar-version-selector': onChangePageVersion,
        'click #dvs-sidebar-add-version': onAddPageVersionBtnClicked,
        'change #dvs-language-selector': onLanguageSelectorChanged,
		'click .dvs-sidebar-save-group': 'save',
		'input form [name]': 'changed',
		'change form [name]': 'changed'
	};

	/**
	 * Sidebar class
	 */
	var Sidebar = function(page)
	{
		this.page = page;
		this.contentView = null;
		this.breadcrumbsView = null;
		this.layout = null;
		this.title = null;
		this.languageSelector = null;
		this.versionsSelector = null;
		this.groupSelector = null;
		this.datePickers = null;
		this.breadcrumbs = null;
		this.grid = null;
		this.manageCollection = null;
		this.validationErrors = null;
		this.content = null;
		this.saveButton = null;
		this.saveNotification = null;
	}

	/**
	 * Sidebar render function turns node into pretty html
	 */
	Sidebar.prototype.render = function(node)
	{
		this.contentView = this.createViewFromBinding(node.binding);
		this.breadcrumbsView = new BreadCrumbsView;

		this.layout = View.make('sidebar.layout', { page: this.page, node: node });
		this.title = this.layout.find('[data-view="sidebar-title"]');
		this.languageSelector = this.layout.find('[data-view="language-selector"]');
		this.versionsSelector = this.layout.find('[data-view="versions-selector"]');
		this.groupSelector = this.layout.find('[data-view="group-selector"]');
		this.datePickers = this.layout.find('[data-view="date-pickers"]');
		this.breadcrumbs = this.layout.filter('[data-view="breadcrumbs"]');
		this.grid = this.layout.filter('[data-view="grid"]');
		this.manageCollection = this.layout.filter('[data-view="manage-collection"]');
		this.validationErrors = this.layout.filter('[data-view="validation-errors"]');
		this.content = this.layout.find('[data-view="content"]');
		this.saveButton = this.layout.find('[data-view="save-button"]');
		this.saveNotification = this.layout.find('[data-view="save-notification"]');

		this.saveButton.hide();

		this.breadcrumbsView.setContainerElement(this.breadcrumbs);
		this.content.append(this.contentView.render(node));
		this.languageSelector.append(View.make('sidebar.partials.language-selector', { page: this.page }));
		this.versionsSelector.append(View.make('sidebar.partials.versions-selector', { page: this.page }));
		this.datePickers.append(View.make('sidebar.partials.date-pickers', { page: this.page }));

		View.registerEvents(this.layout, events, this);

		return this.layout;
	}

	/**
	 * Closes out the sidebar, which resets the node
	 * view
	 */
	Sidebar.prototype.close = function()
	{
		this.contentView.close();
		this.contentView = null;
		this.breadcrumbsView = null;
		this.layout = null;
		this.title = null;
		this.languageSelector = null;
		this.versionsSelector = null;
		this.datePickers = null;
		this.breadcrumbs = null;
		this.manageCollection = null;
		this.content = null;
		this.saveButton = null;
	}

	/**
	 * change the page version id url
	 */
	Sidebar.prototype.changePageVersion = function(pageVersionId)
	{
		if (pageVersionId == this.page.pageVersionId) return;

		var params = query.toJson();

		var pageVersion = View.data.find(this.page.pageVersions, pageVersionId);

		params['page_version'] = pageVersion.name;

		location.href = location.origin + location.pathname + query.toQueryString(params);
	}

    /**
     * Adds page version to this page
     */
    Sidebar.prototype.addPageVersion = function(name)
    {
       var data = { page_version_id: this.page.pageVersionId, name: name };

        $.post('/admin/page-versions', data).then(function(results, status, xhr)
        {
            var href = window.location.origin; // base url of current page
            href += window.location.pathname; // add on current subpage(s)
            href += '?page_version=' + results.name; // add on new page version params
            window.location.href = href;
        });
    }

	/**
	 * Calls save on the underlying content view
	 */
	Sidebar.prototype.save = function(event)
	{
		var form = this.layout.find('form');
		var values = form.serializeObject();

		this.contentView.save(values, event);
	}

	/**
	 * Calls changed on the underlying content view
	 */
	Sidebar.prototype.changed = function(event)
	{
		var el = $(event.currentTarget)
		var name = el.attr('name');
		var value = el.val();
		var type = el.attr('type');

		if (type === 'checkbox')
		{
			value = el.is(':checked') ? value : false;
		}

		switch (name)
		{
			case 'content_requested':
				typeof this.contentView.contentRequestedChanged === 'function' && this.contentView.contentRequestedChanged(value, event);
			break;

			case 'field_scope':
				typeof this.contentView.fieldScopeChanged === 'function' && this.contentView.fieldScopeChanged(value, event);
			break;

			case '_reset_values':
				typeof this.contentView.resetValuesChanged === 'function' && this.contentView.resetValuesChanged(value, event);
			break;

			default: this.contentView.changed(name, value, event);
		}
	}

	/**
	 * Creates a view from this node type
	 */
	Sidebar.prototype.createViewFromBinding = function(binding)
	{
		switch (binding)
		{
			case 'field': 		return new FieldView(this);
			case 'collection': 	return new CollectionView(this);
			case 'model': 		return new ModelView(this);
			case 'attribute': 	return new AttributeView(this);
			case 'group': 		return new GroupView(this);
			case 'creator': 	return new CreatorView(this);
		}

		throw "could not find type of view: " + binding;
	}

	/**
	 * called when the page version is changed
	 */
	function onChangePageVersion(event)
	{
		var pageVersionId = $(event.currentTarget).val();

		this.changePageVersion(pageVersionId);
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
     * handle when language selector changes
     */
    function onLanguageSelectorChanged(event)
    {
    	var url = $(event.currentTarget).find(':selected').data('url');
    	var id = $(event.currentTarget).val();

    	if (id != this.page.languageId)
    	{
    		location.href = url;
    	}
    }

	return Sidebar;
});
devise.define('dvsBaseView',['jquery', 'dvsTemplates'], function($, Templates)
{
    /**
     * Namespace for static class
     */
    var View = { data: {} };


    /**
     * This registers all the events on the given
     * el (jquery) object. Uses thisContext for
     * "this" to the called handler
     */
    View.registerEvents = function(el, events, thisContext)
    {
        $.each(events, function(index, handler)
        {
            var parts = index.split(' ');
            var type = parts.shift();
            var selector = parts.join(' ');

            var thisHandler = (typeof handler === 'string') ? thisContext[handler] : handler;

            if (typeof thisHandler !== 'function')
            {
                throw "invalid handler given: " + handler;
            }

            el.on(type, selector, function() { thisHandler.apply(thisContext, arguments); });
        });
    }

    /**
     * Makes a jquery object from the resulting
     * html string that returns from Templates.make
     */
    View.make = function(template, data)
    {
        var template = Templates.make(template, data);

        return View.compile(template);
    }

    /**
     * Compiles the html into a jquery object
     */
    View.compile = function(html)
    {
        return $('<div/>').html(html).contents();
    }

    /**
     * Renders the template and returns html string
     */
    View.render = function(template, data)
    {
        return Templates.make(template, data);
    }

    /**
     * Filter out data using a json search criteria
     */
    View.data.filter = function(data, searchCriteria)
    {
        var filtered = [];

        $.each(data, function(index, item)
        {
            var matchesCriteria = true;

            $.each(searchCriteria, function(key, value)
            {
                if (typeof item[key] === 'undefined' || item[key] != value)
                {
                    matchesCriteria = false;
                    return false;
                }
            });

            if (matchesCriteria) filtered.push(item);
        });

        return filtered;
    }

    /**
     * Find an item by it's id
     */
    View.data.find = function(data, id)
    {
        var found = null;

        $.each(data, function(index, item)
        {
            if (item.id == id)
            {
                found = item;
                return false; // break from loop
            }
        });

        return found;
    }

    /**
     * Finds the index of this item with an id
     * inside of the data array
     */
    View.data.findIndex = function(data, id)
    {
        var found = -1;

        $.each(data, function(index, item)
        {
            if (item.id == id)
            {
                found = index;
                return false; // break from loop
            }
        });

        return found;
    }

    return View;
});
devise.define('dvsPositionHelper',['jquery'], function($) {

    var nodeHeight = 40;

    /**
     * We need to set the nodeHeight to calculate
     * offsets.
     */
    function setNodeHeight(nodesView)
    {
        nodeHeight = nodesView.children().first().children('.dvs-node-inner-wrapper').height();
    }

    /**
     * This calculates the node positions for all
     * the nodes inside of the nodesData
     */
    function calculateNodePositions(nodesView, nodesData)
    {
        nodesView.children().each(function(index, child)
        {
            var cid = $(child).data('node-cid');
            var node = nodesData[cid];
            var body = nodesView.closest('body');

            // groups have nested nodes inside of them
            if (node.binding === 'group')
            {
                for (var i = 0; i < node.data.length; i++)
                {
                    console.log('here');
                    var current = node.data[i];
                    current.position = getCoordinatesForNode(current, body);
                }
            }

            node.position = getCoordinatesForNode(node, body);
            node.position.side = getSideForNode(node.position);
        });
    }

    /**
     * This adjusts the nodes in the DOM
     * to their new positions
     */
    function adjustNodeDOMPositions(nodesView, nodesData)
    {
        nodesView.children().each(function(index, child)
        {
            var el = $(child);
            var cid = el.data('node-cid');
            var node = nodesData[cid];

            el.css('top', node.position.top);
            el.removeClass('left right');
            el.addClass(node.position.side);
        });
    }

    /**
     * Get the coordinates for this node
     */
    function getCoordinatesForNode(node, view)
    {


        if (node.binding === 'group')
        {
            // if(key == "contentBlock2Icon")
            // console.log(node);
            return getCoordinatesForGroupNode(node, view);
        }

        if (node.binding === 'collection')
        {
            return getCoordinatesForCollectionNode(node, view);
        }

        return getCoordinatesForFieldNode(node.key, node.cid, view);
    }

    /**
     * Finds the position for a collection node
     */
    function getCoordinatesForCollectionNode(node, view)
    {

        var hidden, coordinates;
        var placeholder = view.find('[data-dvs-placeholder^="' + node.key + '["]').last();
        var element = view.find('[data-devise-' + node.cid + ']').first();

        if (element.length)
        {
            hidden = !element.is(':visible');

            if (hidden) element.show();
            coordinates = element.offset();
            if (hidden) element.hide();

            if (typeof coordinates === 'object' && coordinates.top) return coordinates;
            return getCoordinatesFromParent(element);
        }

        placeholder.show();
        coordinates = placeholder.offset();
        placeholder.hide();

        if (typeof coordinates === 'object' && coordinates.top) return coordinates;
        return getCoordinatesFromParent(placeholder);
    }

    /**
     * Get the coordinates for a cid or key inside this view
     */
    function getCoordinatesForFieldNode(key, cid, view)
    {
        var hidden, coordinates;
        var placeholder = view.find('[data-dvs-placeholder="' + key + '"]').last();
        var element = view.find('[data-devise-' + cid + ']').first();

        if (element.length)
        {
            hidden = !element.is(':visible');

            if (hidden) element.show();
            coordinates = element.offset();
            if (hidden) element.hide();

            if (typeof coordinates === 'object' && coordinates.top) return coordinates;
            return getCoordinatesFromParent(element);
        }

        placeholder.show();
        coordinates = placeholder.offset();
        placeholder.hide();

        // if(key == "contentBlock2Icon")
        //     console.log(coordinates);

        if (typeof coordinates === 'object' && coordinates.top) return coordinates;
        return getCoordinatesFromParent(placeholder);
    }

    /**
     * finds the first node in the group with a position
     */
    function getCoordinatesForGroupNode(groupNode, view)
    {
        var position = false;
        var finalTop = 0;
        var finalLeft = 0;
        var nodeCountTop = 0;
        var nodeCountLeft = 0;

        $.each(groupNode.data.categories, function(index, category)
        {
            for (var i = 0; i < category.nodes.length; i++)
            {
                var node = category.nodes[i];
                var nodePosition = getCoordinatesForNode(node, view);

                // If the position isn't 0 then lets throw
                // it in the averages
                if(nodePosition.left != 0) {
                    finalLeft += nodePosition.left;
                    nodeCountLeft++;
                }
                if(nodePosition.top != 0) {
                    finalTop += nodePosition.top;
                    nodeCountTop++;
                }
            }

            // Get it in the ballpark with the last one
            position = nodePosition;

            // Average the top position of the group node
            position.top = finalTop/nodeCountTop;

            // Average the left position of the group node
            position.left = finalLeft/nodeCountLeft;

        });

        return position;
    }

    /**
     * Pick left or right side for this node
     */
    function getSideForNode(coordinates)
    {
        var half = $(window).width() / 2;

        if (typeof coordinates == 'undefined') return 'float';

        if (coordinates.left > half) return 'right';

        return 'left';
    }

    /**
     * This makes sure that no two nodes touch each other
     */
    function solveNodeCollisions(nodesView, nodesData)
    {
        var nodes = nodesData;

        var view = nodesView.closest('body');

        for (var i = 0; i < nodes.length; i++)
        {
            for (var j = 0; j < nodes.length; j++)
            {
                if (i != j && hasNodeCollision(nodes[i], nodes[j]))
                {
                    nodes[i].position.top += nodeHeight;
                    j = 0;
                }
            }
        }
    }

    /**
     * Figures out if we have a node collision
     */
    function hasNodeCollision(node1, node2)
    {
        if (node1.position.side != node2.position.side) return false;

        return Math.abs(node1.position.top - node2.position.top) < (nodeHeight);
    }

    /**
     * Get the coordinates from the parent of this view,
     * sometimes stuff is nested in some deep DOM tree
     * and that stuff is hidden... so hidden elements we
     * cannot get coordinates for because it is hidden.
     * we could try unhiding it but that would give us
     * some flashy stuff on the page...
     */
    function getCoordinatesFromParent(placeholder)
    {
        var sanity = 50;
        var child = placeholder;
        var parent = placeholder.parent();
        var coordinates;

        while (child !== parent && sanity--)
        {
            coordinates = parent.offset();
            if (typeof coordinates === 'object' && coordinates.top) return coordinates;
            child = parent;
            parent = child.parent();
        }

        return { top: 0, left: 0 };
    }

    /**
     * Clean-up routine used to remove placeholder elements from DOM
     * after getting their coordinates.
     */
    function removePlaceholderElements()
    {
        $('#dvs-iframe').contents().find('[data-dvs-placeholder]').remove();
    }

    /**
     * recalculates node positions
     */
    return {
        recalculateNodePositions: function(nodesView, nodesData)
        {
            setNodeHeight(nodesView);
            calculateNodePositions(nodesView, nodesData);
            solveNodeCollisions(nodesView, nodesData);
            adjustNodeDOMPositions(nodesView, nodesData);
            removePlaceholderElements();
        }
    };

});
devise.define('dvsSelectSurrogate',['require', 'jquery'], function (require, $)
{

    var initSurrogate = function()
    {
        var elements = $('.dvs-select');

        applySurrogates(elements);
    };

    function applySurrogates(elements)
    {
        $.each(elements, function(index, el) {
            if($(this).parents('.dvs-select-wrapper').length === 0){
                $(this).removeClass('dvs-select');

                var additionalClasses = $(this).attr('class');

                $(this).wrap("<span class='dvs-select-wrapper " + additionalClasses + "'></span>");
                $(this).after("<span class='dvs-holder'></span>");

                addListeners(this);
            }
        });
    }

    function addListeners(el) {
        $(el).on('change', function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".dvs-holder").text(selectedOption);
        }).trigger('change');
    }

    return initSurrogate;


});
devise.define('dvsLiveUpdater',['dvsLiveUpdate'], function(LiveUpdate)
{
	// returns a global singleton we can work with everywhere
	return new LiveUpdate;
});
devise.define('BindingsFinder',['AttributeBinding', 'ClassBinding', 'StyleBinding', 'TextBinding'], function(AttributeBinding, ClassBinding, StyleBinding, TextBinding)
{
	/**
	 * default lookup
	 */
	var defaultLookup = function(key, database)
	{
		if (typeof database[key] === 'undefined') return '';

		return database[key];
	}

	/**
	 * default database setter
	 */
	var defaultSetter = function(key, value, database)
	{
		database[key] = value;
	}

	/**
	 * Bindings finder finds one way bindings
	 * inside of the DOM
	 */
	var BindingsFinder = function(models, lookup, setter)
	{
		lookup = typeof lookup !== 'function' ? defaultLookup : lookup;
		setter = typeof setter !== 'function' ? defaultSetter : setter;

		this.pattern = new RegExp('###dvsmagic-[^###]+###', 'g');
		this.models = models;
		this.lookup = function(key) { return lookup(key, models); }
		this.setter = function(key, value) { if (key) return setter(key, value, models); }
	}

	/**
	 * finds a list of bindings inside of this node,
	 * recursive in nature. Ideally we can just
	 * pass this the html node (document.childNodes[0])
	 * and it will get all the one-way bindings for us
	 */
	BindingsFinder.prototype.find = function(node)
	{
		var bindings = [];

		bindings = wrapApplyOnBindings(bindings);

		bindings.get = this.lookup;

		bindings.set = this.setter;

		bindings = recursivelyFindAllBindingsInsideOfNode(node, bindings, this);

		return bindings;
	}

	/**
	 * Finds all the bindings from this node and child nodes
	 */
	function recursivelyFindAllBindingsInsideOfNode(node, bindings, finder)
	{
		bindings = findElementBindings(node, bindings, finder);

		bindings = findTextBindings(node, bindings, finder);

		for (var i = 0; i < node.childNodes.length; i++)
		{
		   bindings = recursivelyFindAllBindingsInsideOfNode(node.childNodes[i], bindings, finder);
		}

		return bindings;
	}

	/**
	 * wraps the apply method on the entire array
	 * of bindings
	 */
	function wrapApplyOnBindings(bindings)
	{
		bindings.apply = function(key)
		{
			for (var index in bindings)
			{
				if (index !== 'apply' && typeof bindings[index].apply === 'function')
				{
					if (key) bindings[index].key === key && bindings[index].apply();
					else bindings[index].apply();
				}
			}
		}

		return bindings;
	}
	/**
	 * finds a property from a matched string
	 */
	function findPropertyFromMatch(match)
	{
		var split = match.substring(3, match.length-3).split('-');
		return split[3];
	}

	/**
	 * finds the key from this match
	 */
	function findKeyFromMatch(match)
	{
		var split = match.substring(3, match.length-3).split('-');
		var dvsmagic = split.shift();
		return split.join('-');
	}

	/**
	 * find all the attribute bindings
	 */
	function findElementBindings(node, bindings, finder)
	{
		if (node.nodeType !== node.ELEMENT_NODE || node.__magicAlreadyDone) return bindings;

		for (var i = 0; i < node.attributes.length; i++)
		{
			var attribute = node.attributes[i];
			var matches = attribute.nodeValue.match(finder.pattern);
			var numberOfMatches = matches && matches.length || 0;

			for (var j = 0; j < numberOfMatches; j++)
			{
				var key = findKeyFromMatch(matches[j]);

				if (attribute.name === 'style')
				{
					bindings = findStyleBindings(node, bindings, matches[j], finder.lookup);
				}
				else if (attribute.name === 'class')
				{
					bindings.push(new ClassBinding(node, key, finder.lookup, matches[j]));
				}
				else
				{
					bindings.push(new AttributeBinding(attribute, key, finder.lookup));
				}
			}
		}

		return bindings;
	}

	/**
	 * finds all the text one way bindings
	 */
	function findTextBindings(node, bindings, finder)
	{
		if (node.nodeType !== node.TEXT_NODE || node.__magicAlreadyDone) return bindings;

		var matches = node.nodeValue.match(finder.pattern);

		var numberOfMatches = matches && matches.length || 0;

		if (numberOfMatches === 0) return bindings;

		var segments = createSegmentedText(node, matches);

		for (var i = 0; i < segments.length; i++)
		{
			var newNode = document.createTextNode(segments[i]);
			var index = matches.indexOf(segments[i]);

			if (index > -1)
			{
				var key = findKeyFromMatch(matches[index]);
				bindings.push(new TextBinding(newNode, key, finder.lookup, matches[index]));
			}

			newNode.__magicAlreadyDone = true;
			node.parentNode.insertBefore(newNode, node);
		}

		node.parentNode.removeChild(node);

		return bindings;
	}

	/**
	 * we can have multiple ###dvsmagic### matches found
	 * inside of this text node, we need to segment them
	 * out...
	 */
	function createSegmentedText(textNode, matches)
	{
		var value = textNode.nodeValue;
		var segments = [ value ];

		for (var i = 0; i < matches.length; i++)
		{
			segments = segmentStringsByMatch(segments, matches[i]);
		}

		return segments;
	}

	/**
	 * Segments out the array of strings, separating
	 * them into the smallest text possible. This means
	 * that we should have some index such that
	 * segments[index] === match
	 */
	function segmentStringsByMatch(segments, match)
	{
		var newValues = [];

		for (var i = 0; i < segments.length; i++)
		{
			var value = segments[i];
			var pos = value.indexOf(match);
			var len = match.length;
			var beforeText = value.substr(0, pos);
			var afterText = value.substr(pos + len);

			if (pos === -1)
			{
				newValues.push(value);
				continue;
			}

			if (beforeText.length !== 0) newValues.push(beforeText);

			newValues.push(match);

			if (afterText.length !== 0) newValues.push(afterText);
		}

		return newValues;
	}

	/**
	 * finds all the style bings for all the matches
	 */
	function findStyleBindings(node, bindings, match, lookup)
	{
		var styles = node.attributes.getNamedItem('style').nodeValue.split(';');
		var affected = findAffectedStyles(styles, match);
		var key = findKeyFromMatch(match);

		for (var i = 0; i < affected.length; i++)
		{
			bindings.push(new StyleBinding(node, key, lookup, match, affected[i].style, affected[i].value));
		}

		return bindings;
	}

	/**
	 * find the styles that we need to update
	 */
	function findAffectedStyles(styles, match)
	{
		var affected = [];

		for (var i = 0; i < styles.length; i++)
		{
			var style = styles[i];
			var parts = style.split(':');
			var styleName = typeof parts[0] === 'undefined' ? null : parts[0];
			var styleValue = typeof parts[1] === 'undefined' ? null : parts[1];

			if (!styleValue || !styleName) continue;

			if (styleValue.indexOf(match) !== -1)
			{
				affected.push({
					style: toCamelCase(styleName.trim()),
					value: styleValue.trim()
				});
			}
		}

		return affected;
	}

	/**
	 * renames a str
	 */
	function toCamelCase(str)
	{
		var split = str.split('-');

		for (var i = split.length - 1; i > 0; i--)
		{
			split[i] = split[i].substr(0, 1).toUpperCase() + split[i].substr(1);
		}

		return split.join('');
	}

	return BindingsFinder;
});
devise.define('dvsFieldView',['jquery', 'dvsBaseView', 'dvsLiveUpdater'], function($, View, LiveUpdater)
{
	/**
	 * list of events for this view
	 */
	var events = {

	};

	/**
	 * Constructor for field view
	 */
	var FieldView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.view = null;
		this.loadDefaults = true;
	};

	/**
	 * Renders the entire field in the sidebar,
	 * this includes the layout
	 */
	FieldView.prototype.render = function(node)
	{
		this.data['node'] = node;

		this.view = $('<div/>');

		this.view.append(this.renderField(node.data, true));

		this.sidebar.breadcrumbsView.add(node.human_name, this, 'renderField', [node.data, true]);

		this.sidebar.saveButton.show();

		View.registerEvents(this.view, events, this);

		return this.view;
	}

	/**
	 * Render only the field, this excludes the
	 * layout. Because other things use field
	 * view (like collections) then we use this
	 * method for those things.
	 */
	FieldView.prototype.renderField = function(field, showSitewide)
	{
		var requestContent = View.make('sidebar.partials.request-content', { 'content_requested': field.content_requested });

		var resetValues = View.make('sidebar.partials.reset-values');

		var sitewide = View.make('sidebar.partials.site-wide-field', { 'site_wide': field.scope === 'global' });

		this.data['field'] = field;

		this.loadDefaults === true && LiveUpdater.setDefaultsForField(this.data.field);

		var view = View.make('sidebar.fields.' + field.type, { 'page': this.data.page, 'field': field, 'values': field.values });

		view.find('[data-view="content-requested"]').replaceWith(requestContent);

		view.find('[data-view="reset-values"]').replaceWith(resetValues);

		if (showSitewide) {
			view.find('[data-view="site-wide-field"]').replaceWith(sitewide);
		}

		return view;
	}

	/**
	 * close the field view
	 */
	FieldView.prototype.close = function()
	{
		this.sidebar = null;
		this.data = null;
		this.view = null;
	}

	/**
	 * save the field...
	 */
	FieldView.prototype.save = function(values)
	{
		this.data.field.values = values;

		// set original id and scope before saving (for live updates)
		if (!this.originals)
		{
			this.originals = {};
			this.originals.id = this.data.field.id;
			this.originals.scope = this.data.field.scope;
		}

		var self = this;
		var url = this.data.page.url('update_field', {id: this.data.field.id});
		var data = {
			'field': this.data.field,
			'page': this.data.page.info
		};

		this.sidebar.layout.addClass('saving');

		$.ajax(url, {
			method: 'PUT',
			data: data,
			success: function() { onSaveSuccess.apply(self, arguments); },
			error: function() { onSaveError.apply(self, arguments); }
		});
	}

	/**
	 * called when our form content changes
	 */
	FieldView.prototype.changed = function(attribute, value, event)
	{
		this.data.field.values[attribute] = value;

		LiveUpdater.changedFieldAttribute(this.data.field, attribute);
	}

	/**
	 * content requested field was changed
	 */
	FieldView.prototype.contentRequestedChanged = function(shouldRequestContent)
	{
		this.data.field.content_requested = shouldRequestContent;
	}

	/**
	 * field scope was changed
	 */
	FieldView.prototype.fieldScopeChanged = function(value)
	{
		this.data.field.new_scope = value ? 'global' : 'page';
	}

	/**
	 * reset this fields value if it is okay
	 */
	FieldView.prototype.resetValuesChanged = function(shouldReset)
	{
		if (!shouldReset) return;
		var self = this;

		if (window.confirm("Are you sure you want to reset all values for this field? This will save immediately.")) {

			var field = self.data.field;
			var url = self.data.page.url('reset_field', {id: field.id, scope: field.scope});

			$.post(url);	// reset field on server

			setTimeout(function()
			{
				field.values = {};
				self.view.empty();
				self.loadDefaults = false;
				self.view.append(self.renderField(field, true));
				self.loadDefaults = true;
			}, 500);
		} else {
			self.view.find('#_reset_values').prop('checked', false);
		}
	}

	/**
	 * save was successful, update field values
	 * to reflect what is returned from the server
	 */
	function onSaveSuccess(data, response, xhr)
	{
		// update id's and scope in case they change
		// this happens when switching from global
		// to page specific fields (switching scope)
		this.data.node.data = data;
		this.data.node.data.originals = this.originals;
		this.data.field = this.data.node.data;

		this.view.empty();
		this.view.append(this.renderField(this.data.field, true));
		this.sidebar.layout.removeClass('saving');
		LiveUpdater.changedField(this.data.field);
	}

	/**
	 * save failed to update field, probably
	 * should let the user know or something
	 * with validation messages
	 */
	function onSaveError()
	{
		alert('Could not save field! Check console');
		console.warn('save error', this, arguments);
		this.sidebar.layout.removeClass('saving');
	}

	return FieldView;
});
devise.define('dvsCollectionView',['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsSelectSurrogate', 'dvsLiveUpdater', 'jquery-ui'], function($, View, FieldView, dvsSelectSurrogate, LiveUpdater)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'click #dvs-sidebar-manage-groups': 	onManageInstancesBtnClicked,
		'click #dvs-new-collection-instance': 	onNewCollectionInstanceBtnClicked,
		'change #dvs-groups-select': 			onSelectedInstanceChanged,
		'click [data-show-field]': 				onShowFieldBtnClicked,
		'click [data-remove-instance-id]': 		onRemoveInstanceClicked,
		'change .dvs-collection-instance-name': onCollectionInstanceNameChanged
	};

	/**
	 * Constructor for collection view
	 */
	var CollectionView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.grid = null;
		this.manage = null;
		this.instanceSelector = null;
		this.field = null;
	};

	/**
	 * Handles render method for collection view
	 */
	CollectionView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['instances'] = node.data;
		this.data['collection'] = node.collection;

		this.sidebar.breadcrumbsView.add('All Editors', this, 'renderGridAndSelectorViews');

		this.field = $('<div/>');
		this.manage = $('<div/>');
		this.grid = $('<div/>');
		this.renderGridAndSelectorViews();
		this.data.instances.length === 0 && this.renderManageView();

		return this.field;
	};

	/**
	 * renders the grid and instance selector view
	 */
	CollectionView.prototype.renderGridAndSelectorViews = function()
	{
		this.showingManageView = false;
		this.showingFieldView = false;
		this.renderInstanceSelectorView();
		this.renderGridView();
	}

	/**
	 * Renders the grid view with this data
	 */
	CollectionView.prototype.renderGridView = function()
	{
		if (this.data.instances.length === 0) return;

		!this.selectedInstanceId && this.setSelectedInstanceId(this.instanceSelector.find('#dvs-groups-select').val());

		this.grid = View.make('sidebar.collections.grid', this.data);
		this.grid.show();
		this.sidebar.grid.empty();
		this.sidebar.grid.append(this.grid);

		this.manage.hide();
		this.field.hide();
		this.sidebar.saveButton.hide();

		View.registerEvents(this.grid, events, this);
	}

	/**
	 * Renders the manage view with this data
	 */
	CollectionView.prototype.renderManageView = function()
	{
		var self = this;

		this.manage = View.make('sidebar.collections.manage', this.data);

        var sortable = this.manage.filter('#dvs-collection-instances-sortable').sortable({
            axis: 'y',
            stop: function() { onInstanceOrderChanged.apply(self, arguments); },
            placeholder: 'dvs-sort-placeholder'
        });

        sortable.disableSelection();

		this.manage.show();
		this.grid.hide();
		this.field.hide();
		this.sidebar.manageCollection.show();
        this.sidebar.manageCollection.empty();
		this.sidebar.manageCollection.append(this.manage);
		View.registerEvents(this.manage, events, this);
	}

	/**
	 * Renders the group selector view with this data
	 */
	CollectionView.prototype.renderInstanceSelectorView = function()
	{
		this.instanceSelector = View.make('sidebar.collections.selector', {instances: this.data.instances, selectedInstanceId: this.selectedInstanceId});
		this.sidebar.groupSelector.empty();
		this.sidebar.groupSelector.append(this.instanceSelector);
		this.selectedInstanceId = false;
		dvsSelectSurrogate();	// the dropdown needs to have surrogate select on it
		View.registerEvents(this.instanceSelector, events, this);
	}

	/**
	 * Renders the collection field view
	 */
	CollectionView.prototype.renderCollectionField = function()
	{
		var fieldView = new FieldView(this.sidebar);
		fieldView.loadDefaults = false;

		var html = fieldView.renderField(this.selectedField);

		this.field.empty();
		this.field.append(html);
		this.field.show();
		this.manage.hide();
		this.grid.hide();
		this.sidebar.saveButton.show();
		dvsSelectSurrogate();
	}

	/**
	 * handles the closing of this view to
	 * prevent memeory leaks
	 */
	CollectionView.prototype.close = function()
	{
		this.grid = null;
		this.manage = null;
		this.instanceSelector = null;
		this.field = null;
	}

	/**
	 * Sets the selected instance id on this collection
	 */
	CollectionView.prototype.setSelectedInstanceId = function(instanceId)
	{
		this.selectedInstanceId = instanceId;
		this.selectedInstance = View.data.find(this.data.instances, instanceId);

		$.each(this.data.instances, function(index, instance)
		{
			if (instance.id == instanceId) instance.active = 'dvs-active';
			else instance.active = false;
		});
	}

	/**
	 * save the collection field...
	 */
	CollectionView.prototype.save = function(values)
	{
		this.selectedField.values = values;

		var self = this;
		var url = this.data.page.url('update_collection_field', {id: this.selectedField.id});
		var data = {
			'field': this.selectedField,
			'page': this.data.page.info
		};

		this.sidebar.layout.addClass('saving');

		$.ajax(url, {
			method: 'PUT',
			data: data,
			success: function(data, response, xhr)
			{
				self.sidebar.layout.removeClass('saving');
				self.selectedField = data;
				self.renderCollectionField();
				LiveUpdater.changedField(self.selectedField);
			},
			error: function(xhr, textStatus, error)
			{
				alert('Could not save field! Check console');
				console.warn('save error', arguments);
				self.sidebar.layout.removeClass('saving');
			}
		});
	}

	/**
	 * called when our form content changes
	 */
	CollectionView.prototype.changed = function(key, value, event)
	{
		this.selectedField.values[key] = value;
		LiveUpdater.changedFieldAttribute(this.selectedField, key);
	}

	/**
	 * called when reset values is called
	 */
	CollectionView.prototype.resetValuesChanged = function(shouldReset, event)
	{
		if (!shouldReset) return;

		var self = this;
		this.selectedField.values = {};

		setTimeout(function()
		{
			self.renderCollectionField();
		}, 500);
	}

	/**
	 * Content requested changed
	 */
	CollectionView.prototype.contentRequestedChanged = function(shouldRequestContent)
	{
		this.selectedField.content_requested = shouldRequestContent;
	}

	/**
	 * Create a new collection instance on client side
	 */
	CollectionView.prototype.createNewInstance = function(name)
	{
		var self = this;
		var instance = {};

		instance.id = "new" + this.data.instances.length;
		instance.collection_set_id = this.data.node.collection.id;
		instance.page_version_id = this.data.page.info.page_version_id;
		instance.name = name;
		instance.sort = this.data.instances.length;
		instance.fields = [];

		$.each(this.data.node.schema, function(index, field)
		{
			instance.fields.push({
				collection_instance_id: "new" + self.data.instances.length,
				page_version_id: self.data.page.info.page_version_id,
				type: field.type,
				human_name: field.humanName,
				key: field.key,
				json_value: '{}',
				values: {}
			});
		});

		return instance;
	}

	/**
	 * rearranges the instances in our data to
	 * the new sort order
	 */
	CollectionView.prototype.resortInstances = function(newSortOrder)
	{
		var instances = [];

		for (var order = 0; order < newSortOrder.length; order++)
		{
			var id = newSortOrder[order];
			var instance = View.data.find(this.data.instances, id);

			instance.sort = order;
			instances.push(instance);
		}

		this.data.instances = instances;
	}

	/**
	 * the manage instances button has been clicked
	 */
	function onManageInstancesBtnClicked(event)
	{
		!this.showingManageView && this.sidebar.breadcrumbsView.add('Collections', this, 'renderManageView');
		this.showingManageView = true;
		this.renderManageView();
	}

	/**
	 * The event is triggered when the user
	 * picks a different instance from the
	 * drop down list
	 */
	function onSelectedInstanceChanged(event)
	{
		var selected = $(event.currentTarget);

		var instanceId = selected.val();

		// nothing changed... so don't do anything...
		if (!instanceId || this.selectedInstanceId == instanceId) return;

		this.setSelectedInstanceId(instanceId);

		if (this.showingManageView || this.showingFieldView) this.sidebar.breadcrumbsView.back();
		else this.renderGridView();
	}

	/**
	 * Show the field when this button is clicked
	 */
	function onShowFieldBtnClicked(event)
	{
		var button = $(event.currentTarget);
		var fieldId = button.data('showField');

		this.showingFieldView = true;
		this.selectedField = View.data.find(this.selectedInstance.fields, fieldId);
		this.sidebar.breadcrumbsView.add(this.selectedField.human_name, this, 'renderCollectionField');
		this.renderCollectionField();
	}

	/**
	 * remove this instance id from the collection set
	 */
	function onRemoveInstanceClicked(event)
	{
		var self = this;
		var instanceId = event.currentTarget.dataset.removeInstanceId;
		var instanceIndex = View.data.findIndex(this.data.instances, instanceId);
		var instance = View.data.find(this.data.instances, instanceId);
		var url = this.data.page.url('remove_collection_instance', {id: instanceId, collectionId: this.data.collection.id});
		var txtInput = this.manage.find('#dvs-new-collection-instance-name');
		var data = {};

		this.sidebar.layout.addClass('saving');

		$.ajax(url, {
			method: 'POST',
			data: data,
			success: function()
			{
				self.sidebar.layout.removeClass('saving');
				self.data.instances.splice(instanceIndex, 1);	// remove from instances array
				self.renderInstanceSelectorView();
				self.renderManageView();
				self.manage.find('#dvs-new-collection-instance-name').focus();
			},
			error: function()
			{
				alert('could not remove instance at this time');
				console.warn('could not remove instance at this time', arguments);
				self.sidebar.layout.removeClass('saving');
				self.manage.find('#dvs-new-collection-instance-name').focus();
			}
		});
	}

	/**
	 * add a new collection instance to the database
	 */
	function onNewCollectionInstanceBtnClicked(event)
	{
		var self = this;
		var btn = $(event.currentTarget);
		var txtInput = btn.parent().find('#dvs-new-collection-instance-name');
		var name = txtInput.val();
		var instance = this.createNewInstance(name);
		var instanceIndex = this.data.instances.length;
		var url = this.data.page.url('add_collection_instance', { pageVersionId: this.data.page.info.page_version_id, collectionId: this.data.collection.id});

		if (!name) {
			return;
		}

		txtInput.val('');
		this.data.instances[instanceIndex] = instance;
		this.renderManageView();
		this.sidebar.layout.addClass('saving');

		$.ajax(url, {
			method: 'POST',
			data: instance,
			success: function(data)
			{
				self.sidebar.layout.removeClass('saving');
				self.data.instances[instanceIndex] = data;
				self.renderInstanceSelectorView();
				self.renderManageView();
				self.manage.find('#dvs-new-collection-instance-name').focus();
				// LiveUpdater.refresh();	// we decided to take this out...
			},
			error: function()
			{
				alert('could not add instance at this time');
				console.warn('could not add instance at this time', arguments);
				self.sidebar.layout.removeClass('saving');
				self.data.instances.splice(instanceIndex, 1);	// remove from instances array
				self.renderManageView();
				self.manage.find('#dvs-new-collection-instance-name').focus();
			}
		});
	}

	/**
	 * sort order of this collection's instances has
	 * changed, so update server
	 */
	function onInstanceOrderChanged(event)
	{
		var self = this;
		var instanceIds = [];
		var url = this.data.page.url('sort_collection_instance', { pageVersionId: this.data.page.info.page_version_id, collectionId: this.data.collection.id});
		var sorting = this.manage.filter('#dvs-collection-instances-sortable');

		sorting.children().each(function(index, instanceEl)
		{
			instanceIds.push(instanceEl.dataset.instanceId);
		});

		$.ajax(url, {
			method: 'POST',
			data: {'instances' : instanceIds },
			success: function()
			{
				self.resortInstances(instanceIds);
				self.renderInstanceSelectorView();
			},
			error: function()
			{
				alert('could not sort instance');
				console.warn('could not sort instance', arguments);
				self.renderManageView();
			}
		});
	}

	/**
	 * The collection instance name has been changed...
	 */
	function onCollectionInstanceNameChanged(event)
	{
		var self = this;
		var instanceId = event.currentTarget.dataset.instanceId;
		var name = event.currentTarget.value;
		var url = this.data.page.url('update_collection_instance', { pageVersionId: this.data.page.info.page_version_id, collectionId: this.data.collection.id, id: instanceId});
		var instance = View.data.find(this.data.instances, instanceId);
		var previousName = instance.name;

		instance.name = name;

		$.ajax(url, {
			method: 'PUT',
			data: instance,
			success: function()
			{
				self.renderInstanceSelectorView();
			},
			error: function()
			{
				alert('could not rename instance');
				console.warn('could not rename instance', arguments);
				instance.name = previousName;
				self.renderManageView();
			}
		});
	}

	return CollectionView;
});
devise.define('dvsModelView',['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsLiveUpdater'], function($, View, FieldView, LiveUpdater)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'click [data-model-field-id]': onShowModelFieldBtnClicked,
	};

	/**
	 * Constructor for model view
	 */
	var ModelView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.grid = null;
		this.field = null;
	};

	/**
	 * Renders the entire model in the sidebar,
	 * this includes the layout
	 */
	ModelView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['fields'] = node.data;
		this.data['model'] = node.model;

		this.field = $('<div/>');
		this.renderGridView();
		this.sidebar.breadcrumbsView.add(node.human_name, this, 'showGridView');

		return this.field;
	}

	/**
	 * close the model view
	 */
	ModelView.prototype.close = function()
	{
		this.data = null;
		this.grid = null;
		this.field = null;
	}

	/**
	 * Shows the model field view
	 */
	ModelView.prototype.showModelFieldView = function(fieldId)
	{
		var field = this.renderModelField(fieldId);
		this.sidebar.breadcrumbsView.add(this.data.field.mapping, this, 'showModelFieldView', [fieldId]);
		this.field.empty();
		this.field.append(field);
		this.field.show();
		this.grid.hide();
		this.sidebar.saveButton.show();
	}

	/**
	 * Shows the validation errors
	 */
	ModelView.prototype.showValidationErrorsView = function(errors)
	{
		var html = View.make('sidebar.partials.errors', {'errors': errors});
		this.sidebar.validationErrors.empty();
		this.sidebar.validationErrors.append(html);
	}

	/**
	 * Renders a model field
	 */
	ModelView.prototype.renderModelField = function(fieldId)
	{
		var fieldView = new FieldView(this.sidebar);
		var field = View.data.find(this.data.fields, fieldId);
		var html = fieldView.renderField(field);

		this.data.field = field;

		return html;
	}

	/**
	 * Shows the model view
	 */
	ModelView.prototype.showGridView = function()
	{
		this.field.empty();
		this.grid.show();
		this.sidebar.saveButton.hide();
	}

	/**
	 * save the field...
	 */
	ModelView.prototype.save = function(values)
	{
		this.data.field.values = values;

		var self = this;
		var url = this.data.page.url('update_model_fields');
		var data = {
			'fields': this.data.fields,
			'page': this.data.page.info
		};

		this.sidebar.layout.addClass('saving');
		this.sidebar.validationErrors.empty();

		$.ajax(url, {
			method: 'PUT',
			data: data,
			success: function() { onSaveSuccess.apply(self, arguments); },
			error: function() { onSaveError.apply(self, arguments); }
		});
	}

	/**
	 * called when our form content changes
	 */
	ModelView.prototype.changed = function(key, value, event)
	{
		this.data.field.values[key] = value;
		LiveUpdater.changedModelAttribute(this.data.field, key);
	}

	/**
	 * Changed when the content is requested field is changed
	 */
	ModelView.prototype.contentRequestedChanged = function(shouldRequestContent)
	{
		this.data.field.content_requested = shouldRequestContent;
	}

	/**
	 * reset this fields value if it is okay
	 */
	ModelView.prototype.resetValuesChanged = function(shouldReset)
	{
		if (!shouldReset) return;

		var self = this;
		var field = this.data.field;

		setTimeout(function()
		{
			field.values = {}
			self.field.empty();
			self.field.append(self.renderModelField(field.id));
		}, 500);
	}

	/**
	 * Re-renders the grid view (useful when content
	 * requested changes)
	 */
	ModelView.prototype.renderGridView = function()
	{
		this.grid = View.make('sidebar.models.grid', this.data);
		this.sidebar.grid.empty();
		this.sidebar.grid.append(this.grid);
		View.registerEvents(this.grid, events, this);
	}

	/**
	 * save was successful, update field values
	 * to reflect what is returned from the server
	 */
	function onSaveSuccess(data, response, xhr)
	{
		this.sidebar.layout.removeClass('saving');
		this.data.fields = data.fields;
		this.sidebar.breadcrumbsView.back();
		this.renderGridView();
		this.showGridView();
		LiveUpdater.changedModel(this.data.field);
	}

	/**
	 * save failed to update field, probably
	 * should let the user know or something
	 * with validation messages
	 */
	function onSaveError(xhr, textStatus, errorThrown)
	{
		if (xhr.status !== 403)
		{
			console.warn('save error', xhr, textStatus, errorThrown);
			alert('Could not save field due to unknown error.');
			return;
		}

		var html = View.make('sidebar.partials.errors', {'errors': xhr.responseJSON.errors});
		this.sidebar.layout.removeClass('saving');
		this.sidebar.validationErrors.empty();
		this.sidebar.validationErrors.append(html);
		this.sidebar.breadcrumbsView.back();
		this.showGridView();
	}


	/**
	 * the show model field button has been clicked
	 */
	function onShowModelFieldBtnClicked(event)
	{
		var fieldId = event.currentTarget.dataset.modelFieldId;

		this.showModelFieldView(fieldId);
	}

	return ModelView;
});
devise.define('dvsAttributeView',['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsLiveUpdater'], function($, View, FieldView, LiveUpdater)
{
	/**
	 * list of events for this view
	 */
	var events = {

	};

	/**
	 * constructor for attribute view
	 */
	var AttributeView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.view = null;
		this.fieldView = null;
	};

	/**
	 * renders the entire attribute in the sidebar,
	 * this includes the layout
	 */
	AttributeView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['field'] = node.data;
		this.data['model'] = node.model;

		this.fieldView = new FieldView(this.sidebar);

		this.view = $('<div/>');

		this.renderField();

		this.sidebar.breadcrumbsView.add(node.human_name, this, 'renderField');

		View.registerEvents(this.view, events, this);

		return this.view;
	}

	/**
	 * renders the field view
	 */
	AttributeView.prototype.renderField = function()
	{
		this.view.empty();

		this.view.append(this.fieldView.renderField(this.data.field));

		this.sidebar.saveButton.show();
	}

	/**
	 * close the attribute view
	 */
	AttributeView.prototype.close = function()
	{
		this.sidebar = null;
		this.data = null;
		this.view = null;
		this.fieldView = null;
	}

	/**
	 * save the attribute field...
	 */
	AttributeView.prototype.save = function(values)
	{
		this.data.field.values = values;

		var self = this;
		var url = this.data.page.url('update_model_attribute', {id: this.data.field.id});
		var data = {
			'field': this.data.field,
			'page': this.data.page.info
		};

		this.sidebar.validationErrors.empty();
		this.sidebar.layout.addClass('saving');

		$.ajax(url, {
			method: 'PUT',
			data: data,
			success: function() { onSaveSuccess.apply(self, arguments); },
			error: function() { onSaveError.apply(self, arguments); }
		});


	}

	/**
	 * called when our form content changes
	 */
	AttributeView.prototype.changed = function(key, value, event)
	{
		this.data.field.values[key] = value;
		LiveUpdater.changedModelAttribute(this.data.field, key);
	}

	/**
	 * Changed when the content is requested field is changed
	 */
	AttributeView.prototype.contentRequestedChanged = function(shouldRequestContent)
	{
		this.data.field.content_requested = shouldRequestContent;
	}

	/**
	 * reset this fields value if it is okay
	 */
	AttributeView.prototype.resetValuesChanged = function(shouldReset)
	{
		if (!shouldReset) return;

		var self = this;

		setTimeout(function()
		{
			self.data.field.values = {}
			self.renderField();
		}, 500);
	}

	/**
	 * save was successful, update field values
	 * to reflect what is returned from the server
	 */
	function onSaveSuccess(data, response, xhr)
	{
		this.sidebar.layout.removeClass('saving');
		this.data.field = data.field;
		LiveUpdater.changedModel(this.data.field);
	}

	/**
	 * save failed to update field, probably
	 * should let the user know or something
	 * with validation messages
	 */
	function onSaveError(xhr, textStatus, errorThrown)
	{
		if (xhr.status !== 403)
		{
			console.warn('save error', xhr, textStatus, errorThrown);
			alert('Could not save field due to unknown error.');
			return;
		}

		var html = View.make('sidebar.partials.errors', {'errors': xhr.responseJSON.errors});
		this.sidebar.layout.removeClass('saving');
		this.sidebar.validationErrors.empty();
		this.sidebar.validationErrors.append(html);
	}

	return AttributeView;
});
devise.define('dvsCreatorView',['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsLiveUpdater'], function($, View, FieldView, LiveUpdater)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'click [data-creator-attribute-name]': onShowCreatorAttributeNameBtnClicked,
	};

	/**
	 * Constructor for model view
	 */
	var CreatorView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page, attributes: {} };
		this.grid = null;
		this.field = null;
	};

	/**
	 * Renders the entire model in the sidebar,
	 * this includes the layout
	 */
	CreatorView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['creator'] = node.data;

		this.createDefaultFields(this.data.creator);

		this.field = $('<div/>');

		this.grid = View.make('sidebar.creators.grid', this.data);

		this.sidebar.grid.append(this.grid);

		this.sidebar.breadcrumbsView.add(node.human_name, this, 'showGridView');

		View.registerEvents(this.grid, events, this);

		return this.field;
	}

	/**
	 * close the model view
	 */
	CreatorView.prototype.close = function()
	{
		this.data = null;
		this.grid = null;
		this.field = null;
	}

	/**
	 * Shows the model field view
	 */
	CreatorView.prototype.showFieldView = function(name)
	{
		var fieldView = new FieldView(this.sidebar);
		var field = View.data.find(this.data.fields, name);
		var html = fieldView.renderField(field);

		this.sidebar.breadcrumbsView.add(name, this, 'showFieldView', [name]);
		this.data.field = field;

		this.field.empty();
		this.field.append(html);
		this.field.show();
		this.grid.hide();
		this.sidebar.saveButton.show();
	}

	/**
	 * Shows the model view
	 */
	CreatorView.prototype.showGridView = function()
	{
		this.field.empty();
		this.grid.show();
		this.sidebar.saveButton.hide();
	}

	/**
	 * makes default fields for this creator
	 */
	CreatorView.prototype.createDefaultFields = function(creator)
	{
		var fields = [];

		$.each(creator.types, function(mapping, type)
		{
			fields.push({
				id: mapping,
				mapping: mapping,
				model_type: creator.model_type,
				type: type,
				values: $.extend({}, creator.defaults)
			});
		});

		this.data['fields'] = fields;
	}

	/**
	 * save the field...
	 */
	CreatorView.prototype.save = function(values)
	{
		this.data.fields.values = values;

		var self = this;
		var url = this.data.page.url('create_model');
		var data = {
			'fields': this.data.fields,
			'page': this.data.page.info
		};

		this.sidebar.layout.addClass('saving');
		this.sidebar.validationErrors.empty();

		$.ajax(url, {
			method: 'POST',
			data: data,
			success: function() { onSaveSuccess.apply(self, arguments); },
			error: function() { onSaveError.apply(self, arguments); }
		});
	}

	/**
	 * called when our form content changes
	 */
	CreatorView.prototype.changed = function(key, value, event)
	{
		this.data.field.values[key] = value;
	}

	/**
	 * save was successful, update field values
	 * to reflect what is returned from the server
	 */
	function onSaveSuccess(data, response, xhr)
	{
		this.createDefaultFields(this.data.creator);
		this.sidebar.breadcrumbsView.back();
		this.sidebar.layout.removeClass('saving');
		this.showGridView();
		// LiveUpdater.refresh(); // decided to remove this for now
	}

	/**
	 * save failed to update field, probably
	 * should let the user know or something
	 * with validation messages
	 */
	function onSaveError(xhr, textStatus, errorThrown)
	{
		if (xhr.status !== 403)
		{
			console.warn('save error', xhr, textStatus, errorThrown);
			alert('Could not save field due to unknown error.');
			return;
		}

		var html = View.make('sidebar.partials.errors', {'errors': xhr.responseJSON.errors});
		this.sidebar.layout.removeClass('saving');
		this.sidebar.validationErrors.empty();
		this.sidebar.validationErrors.append(html);
		this.sidebar.breadcrumbsView.back();
		this.showGridView();
	}

	/**
	 * the show model field button has been clicked
	 */
	function onShowCreatorAttributeNameBtnClicked(event)
	{
		var name = event.currentTarget.dataset.creatorAttributeName;

		this.showFieldView(name);
	}

	return CreatorView;
});
devise.define('dvsGroupView',['jquery', 'dvsBaseView', 'dvsSelectSurrogate'], function($, View, dvsSelectSurrogate)
{
	/**
	 * list of events for this view
	 */
	var events = {
		'click [data-show-node]': onShowNodeBtnClicked,
		'change [data-category-selector]': onCategoryChanged,
	};

	/**
	 * constructor for group view
	 */
	var GroupView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.content = null;
		this.grid = null;
		this.categorySelector = null;
		this.contentView = null;
	};

	/**
	 * renders the group in the sidebar
	 */
	GroupView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['categories'] = node.data.categories;
		this.content = $('<div/>');

		this.sidebar.breadcrumbsView.add(node.human_name, this, 'renderGridAndSelectorViews');
		this.showingCategoryIndex = 0;
		this.showingNodeIndex = false;

		this.renderGridView();
		this.renderCategorySelectorView();

		return this.content;
	}

	/**
	 * render grid and selector views both
	 */
	GroupView.prototype.renderGridAndSelectorViews = function()
	{
		this.renderGridView();
		this.renderCategorySelectorView();
	}

	/**
	 * renders the grid view for this grouping
	 */
	GroupView.prototype.renderGridView = function()
	{
		for (var i = 0; i < this.data.categories.length; i++) this.data.categories[i].active = false;

		this.contentView && this.contentView.close();
		this.contentView = null;
		this.content.empty();
		this.data.categories[this.showingCategoryIndex].active = 'dvs-active';
		this.grid = View.make('sidebar.groups.grid', this.data);
		this.sidebar.grid.empty();
		this.sidebar.grid.append(this.grid);
		this.sidebar.saveButton.hide();
		this.sidebar.manageCollection.empty();
		this.sidebar.validationErrors.empty();
		View.registerEvents(this.grid, events, this);
	}

	/**
	 * renders the category selector view for this group
	 */
	GroupView.prototype.renderCategorySelectorView = function()
	{
		this.sidebar.groupSelector.empty();

		// if there is only 1 category, we don't show selector
		if (this.data.categories.length < 2) return;

		this.categorySelector = View.make('sidebar.groups.selector', {showingCategoryIndex: this.showingCategoryIndex, categories: this.data.categories});
		this.sidebar.groupSelector.append(this.categorySelector);
		dvsSelectSurrogate();
		View.registerEvents(this.categorySelector, events, this);
	}

	/**
	 * renders the underlying node's content view
	 */
	GroupView.prototype.renderContentView = function(node)
	{
		this.contentView && this.contentView.close();
		this.sidebar.grid.empty();
		this.contentView = this.sidebar.createViewFromBinding(node.binding);
		this.content.empty();
		this.content.append(this.contentView.render(node));
	}

	/**
	 * close the group view
	 */
	GroupView.prototype.close = function()
	{
		this.contentView && this.contentView.close();
		this.contentView = null;
		this.data = null;
		this.content = null;
		this.grid = null;
		this.categorySelector = null;
	}

	/**
	 * save the field...
	 */
	GroupView.prototype.save = function(values, event)
	{
		this.contentView.save(values, event);
	}

	/**
	 * called when our form content changes
	 */
	GroupView.prototype.changed = function(key, value, event)
	{
		this.contentView.changed(key, value, event);
	}

	/**
	 * content requested field was changed
	 */
	GroupView.prototype.contentRequestedChanged = function(shouldRequestContent)
	{
		typeof this.contentView.contentRequestedChanged === 'function' && this.contentView.contentRequestedChanged(shouldRequestContent);
	}

	/**
	 * field scope was changed
	 */
	GroupView.prototype.fieldScopeChanged = function(value)
	{
		typeof this.contentView.fieldScopeChanged === 'function' && this.contentView.fieldScopeChanged(value);
	}

	/**
	 * reset this fields value if it is okay
	 */
	GroupView.prototype.resetValuesChanged = function(shouldReset)
	{
		typeof this.contentView.resetValuesChanged === 'function' && this.contentView.resetValuesChanged(shouldReset);
	}

	/**
	 * the node button has been clicked, we should show
	 * this node now
	 */
	function onShowNodeBtnClicked(event)
	{
		var nodeIndex = event.currentTarget.dataset.showNode;
		var node = this.data.categories[this.showingCategoryIndex].nodes[nodeIndex];

		this.showingNodeIndex = nodeIndex;
		this.renderContentView(node);
	}

	/**
	 * change the category index
	 */
	function onCategoryChanged(event)
	{
		var newCategoryIndex = parseInt(event.currentTarget.value);

		// when index hasn't changed, no soup for you...
		if (this.showingCategoryIndex == newCategoryIndex) return;

		this.showingCategoryIndex = newCategoryIndex;
		this.sidebar.breadcrumbsView.back(0);
		this.renderCategorySelectorView();
	}

	return GroupView;
});
devise.define('dvsBreadCrumbsView',['jquery', 'dvsBaseView'], function($, View)
{
	/**
	 * Events for the bread crumbs view container
	 */
	var events = {
		'click [data-breadcrumb-id]': onBreadCrumbClicked
	};

	/**
	 * constrcutor for bread crumbs view class
	 */
	var BreadCrumbsView = function()
	{
		this.container = $('<div/>');
		this.breadcrumbs = [];
	}

	/**
	 * adds the container element to this breadcrumbs manager
	 */
	BreadCrumbsView.prototype.setContainerElement = function(element)
	{
		this.container = element;
		View.registerEvents(this.container, events, this);
	}

	/**
	 * add in a new breadcrumb
	 */
	BreadCrumbsView.prototype.add = function(name, context, handler, args)
	{
		if (typeof name !== 'string') {
			throw "cannot add breadcrumb without name";
		}

		if (typeof context !== 'object') {
			throw "cannot add breacrumb without context";
		}

		if (typeof handler !== 'string') {
			throw "cannot add breacrumb without back handler";
		}

		if (typeof args === 'undefined') {
			args = [];
		}

		if (this.breadcrumbs.length > 0) {
			this.breadcrumbs[this.breadcrumbs.length - 1].last = false;
		}

		this.breadcrumbs.push({
			id: this.breadcrumbs.length,
			last: true,
			name: name,
			handler: handler,
			context: context,
			args: args
		});

		this.container.empty();
		this.container.append(this.render());
		this.container.show();
		this.breadcrumbs.length < 2 && this.container.hide();
	}


	/**
	 * runs the back handler for this given index
	 */
	BreadCrumbsView.prototype.back = function(origIndex)
	{
		if (typeof origIndex === 'undefined') {
			origIndex = this.breadcrumbs.length - 2;
		}

		var index = parseInt(origIndex);

		if (isNaN(index) || index > this.breadcrumbs.length - 1 || index < 0) {
			throw "cannot go back to " + origIndex;
		}

		var crumb = this.breadcrumbs[index];
		crumb.context[crumb.handler].apply(crumb.context, crumb.args);

		this.breadcrumbs = this.breadcrumbs.splice(0, index + 1);
		this.breadcrumbs[index].last = true;
		this.container.empty();
		this.container.append(this.render());
		this.breadcrumbs.length < 2 && this.container.hide();
	}

	/**
	 * Renders the breadcrumb breadcrumbs
	 */
	BreadCrumbsView.prototype.render = function()
	{
		return View.make('sidebar.partials.breadcrumbs', {'breadcrumbs': this.breadcrumbs});
	}

	/**
	 * Shows the breadcrumbs container
	 */
	BreadCrumbsView.prototype.show = function()
	{
		this.container.show();
	}

	/**
	 * Hides the breadcrumbs container
	 */
	BreadCrumbsView.prototype.hide = function()
	{
		this.container.hide();
	}

	/**
	 * handles the jquery event for when
	 * a bread crumb is clicked
	 */
	function onBreadCrumbClicked(event)
	{
		var breadcrumbId = event.currentTarget.dataset.breadcrumbId;

		this.back(breadcrumbId);
	}

	/**
	 * Return class for bread crumbs view
	 */
	return BreadCrumbsView;
});
devise.define('dvsLiveUpdate',['jquery', 'query'], function($, query)
{
	/**
	 * Create a new live update class
	 */
	var LiveUpdate = function()
	{
		this.iframe = $('<iframe />');
		this.bindings = [];
		this.bindings.apply = function() {};
		this.bindings.get = function(key) {};
		this.bindings.set = function(key, value) {};
	}

	/**
	 * Set the iframe for this live updater
	 */
	LiveUpdate.prototype.setup = function(iframe, bindings, database)
	{
		this.iframe = iframe;
		this.bindings = bindings;
		this.database = database;
	}

	/**
	 * Change the bindings database...
	 */
	LiveUpdate.prototype.changedFieldAttribute = function(field, attribute)
	{
		var key = _key(field, attribute);
		var value = _value(field, attribute);

		this.bindings.set(key, value);
		this.bindings.apply(key);
	}

	/**
	 * update a bunch of values all at once using
	 * the entire field
	 */
	LiveUpdate.prototype.changedField = function(field)
	{
		for (var attribute in field.values)
		{
			this.changedFieldAttribute(field, attribute);
		}
	}

	/**
	 * Update all of the attributes for this field
	 */
	LiveUpdate.prototype.changedModel = function(field)
	{
		for (var attribute in field.values)
		{
			this.changedModelAttribute(field, attribute);
		}
	}

	/**
	 * update this key inside of this field
	 */
	LiveUpdate.prototype.changedModelAttribute = function(field, attribute)
	{
		var key = _model_key(field, attribute);
		var value = _value(field, attribute);

		if (key)
		{
			this.bindings.set(key, value);
			this.bindings.apply(key);
		}
	}

	/**
	 * sets the default values set for this field
	 * this only works for values not set inside of this
	 * field
	 */
	LiveUpdate.prototype.setDefaultsForField = function(field)
	{
		var defaults = this.getDefaultsForField(field);

		for (var attribute in defaults)
		{
			if (typeof field.values[attribute] === 'undefined' || !field.values[attribute])
			{
				field.values[attribute] = defaults[attribute];
			}
		}
	}

	/**
	 * finds all the defaults that are in the system for this
	 */
	LiveUpdate.prototype.getDefaultsForField = function(field)
	{
		var defaults = {};
		var fieldKey = _key(field, '');

		for (var key in this.database)
		{
			if (key.match(fieldKey))
			{
				var attribute = key.replace(fieldKey, '');
				defaults[attribute] = this.database[key];
			}
		}

		return defaults;
	}


	/**
	 * Occasionally it makes sense to refresh the entire
	 * iframe so that we get a new updated view...
	 */
	LiveUpdate.prototype.refresh = function()
	{
		typeof this.iframe[0] !== 'undefined' &&
		typeof this.iframe[0].contentWindow !== 'undefined' &&
		typeof this.iframe[0].contentWindow.location !== 'undefined' &&
		typeof this.iframe[0].contentWindow.location.reload !== 'undefined' &&
		this.iframe[0].contentWindow.location.reload(true);
	}

	/**
	 * unique key for model field types
	 */
	function _model_key(field, attribute)
	{
		var pick = false;
		var type = field.model_type;
		var id = field.model_id;

		for (var index in field.picks)
		{
			if (field.picks[index] === attribute)
			{
				pick = index;
				break;
			}
		}

		return pick ? type + '-' + id + '-' + pick : false;
	}

	/**
	 * unique key for this field and attribute
	 */
	function _key(field, attribute)
	{
		if (field.originals)
		{
			return field.originals.scope + '-' + field.originals.id + '-' + attribute;
		}

		return field.scope + '-' + field.id + '-' + attribute;
	}

	/**
	 * value for this field and attribute pair
	 */
	function _value(field, attribute)
	{
		return field.values[attribute];
	}

	return LiveUpdate;
});
devise.define('AttributeBinding',[], function()
{
	/**
	 * one way bindings for attributes
	 */
	var AttributeBinding = function(node, key, lookup)
	{
		this.node = node;
		this.key = key;
		this.lookup = lookup;
	}

	/**
	 * updates values for this node
	 */
	AttributeBinding.prototype.apply = function()
	{
		var value = this.lookup(this.key);
		this.old = this.node.nodeValue;
		this.node.nodeValue = value;
	}

	return AttributeBinding;
});
devise.define('ClassBinding',[], function()
{
	/**
	 * one-way bindings for class attribute
	 */
	var ClassBinding = function(node, key, lookup, match)
	{
		this.node = node;
		this.key = key;
		this.lookup = lookup;
		this.old = this.match;
		this.oldValues = [this.match];
	}

	/**
	 * updates values for this node
	 */
	ClassBinding.prototype.apply = function()
	{
		var value = this.lookup(this.key);

		value = value.replace(new RegExp(',', 'g'), '');

		if (value === '') value = this.match;
		if (value === this.old) return;

		var values = value.split(' ');

		for (var i = 0; i < this.oldValues.length; i++)
		{
			this.oldValues[i] && this.node.classList.remove(this.oldValues[i]);
		}

		for (var i = 0; i < values.length; i++)
		{
			values[i] && this.node.classList.add(values[i]);
		}

		this.old = value;
		this.oldValues = values;
	}

	return ClassBinding;
});
devise.define('StyleBinding',[], function()
{
	/**
	 * one-way bindings for style attribute
	 */
	var StyleBinding = function(node, key, lookup, match, style, value)
	{
		this.node = node;
		this.key = key;
		this.match = match;
		this.lookup = lookup;
		this.style = style;
		this.value = value;
	}

	/**
	 * updates the styles for this node
	 */
	StyleBinding.prototype.apply = function()
	{
		var value = this.lookup(this.key);

		var newValue = strReplace(this.match, value.toString(), this.value);

		if (!value)
		{
			this.node.style[this.style] = 'inherit';
		}
		else
		{
			this.node.style[this.style] = newValue;
		}
	}

	/**
	 * replace the old value with new value in the style
	 */
	function strReplace(needle, replacement, haystack)
	{
		if (!needle) return haystack;

		return haystack.replace(new RegExp(needle, 'g'), replacement);
	}

	return StyleBinding;
});
devise.define('TextBinding',['jquery'], function($)
{
	/**
	 * one-way bindings for text nodes
	 */
	var TextBinding = function(node, key, lookup, match)
	{
		this.match = match;
		this.key = key;
		this.lookup = lookup;
		this.old = match;
		this.nodes = [node];
	}

	/**
	 * updates the nodes' to have correct value
	 */
	TextBinding.prototype.apply = function()
	{
		var value = this.lookup(this.key);

		if (this.old === value) return;
		if (!this.parentNode) this.parentNode = this.nodes[0].parentNode;

		var firstNode = this.nodes[0];
		var nodes = createNodesFromHtml(value);

		for (var i = 0; i < nodes.length; i++)
		{
			this.parentNode.insertBefore(nodes[i], firstNode);
		}

		for (var i = 0; i < this.nodes.length; i++)
		{
			this.parentNode.removeChild(this.nodes[i]);
		}

		this.old = value;
		this.nodes = nodes;
	}

	/**
	 * creates nodes for this html value
	 */
	function createNodesFromHtml(value)
	{
		if (!value || value === '') return [ document.createTextNode('') ];

		var nodes = [];

		var childNodes = [];

		var el = $('<div/>');

		el.html(value);

		childNodes = el[0].childNodes;

		for (var i = 0; i < childNodes.length; i++)
		{
			nodes.push(childNodes[i].cloneNode(true));
		}

		return nodes;
	}

	return TextBinding;
});}());
devise.require(['jquery'], function($){ devise.$ = $; });