devise.define(['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsCollectionView', 'dvsModelView', 'dvsAttributeView', 'dvsGroupView', 'dvsBreadCrumbsView'], function($, View, FieldView, CollectionView, ModelView, AttributeView, GroupView, BreadCrumbsView)
{
	/**
	 * List of events for this view
	 */
	var events = {
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
		this.datePickers = null;
		this.breadcrumbs = null;
		this.grids = null;
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
		this.datePickers = this.layout.find('[data-view="date-pickers"]');
		this.breadcrumbs = this.layout.filter('[data-view="breadcrumbs"]');
		this.grids = this.layout.filter('[data-view="grids"]');
		this.content = this.layout.find('[data-view="content"]');
		this.saveButton = this.layout.find('[data-view="save-button"]');

		this.breadcrumbsView.setContainerElement(this.breadcrumbs);
		this.content.append(this.contentView.render(node));
		this.languageSelector.append(View.make('sidebar.partials.language-selector', { page: this.page }));
		this.versionsSelector.append(View.make('sidebar.partials.versions-selector', { page: this.page }));
		this.datePickers.append(View.make('sidebar.partials.date-pickers', { page: this.page }));

		View.registerEvents(this.layout, events, this);
		this.saveButton.hide();

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
		this.content = null;
		this.saveButton = null;
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
		this.contentView.changed(event);
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

	return Sidebar;
});