devise.define(['jquery', 'dvsBaseView', 'dvsSelectSurrogate'], function($, View, dvsSelectSurrogate)
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
	GroupView.prototype.save = function(event)
	{
		this.contentView.save(event);
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