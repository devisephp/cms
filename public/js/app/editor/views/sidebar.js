devise.define(['jquery', 'query', 'dvsBaseView', 'dvsFieldView', 'dvsCollectionView', 'dvsModelView', 'dvsAttributeView', 'dvsCreatorView', 'dvsGroupView', 'dvsBreadCrumbsView'], function($, query, View, FieldView, CollectionView, ModelView, AttributeView, CreatorView, GroupView, BreadCrumbsView)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'change #dvs-sidebar-version-selector': onChangePageVersion,
		'click .dvs-sidebar-save-group': 'save',
		'input form input': 'changed',
		'change form input': 'changed',
		'change form select': 'changed'
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
	}

	/**
	 * Sidebar render function turns node into pretty html
	 */
	Sidebar.prototype.render = function(node)
	{
		this.contentView = createViewFrom(this, node.binding);
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
	 * Calls save on the underlying content view
	 */
	Sidebar.prototype.save = function()
	{
		this.contentView.save();
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
	function createViewFrom(sidebar, binding)
	{
		switch (binding)
		{
			case 'field': 		return new FieldView(sidebar);
			case 'collection': 	return new CollectionView(sidebar);
			case 'model': 		return new ModelView(sidebar);
			case 'attribute': 	return new AttributeView(sidebar);
			case 'group': 		return new GroupView(sidebar);
			case 'creator': 	return new CreatorView(sidebar);
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

	return Sidebar;
});