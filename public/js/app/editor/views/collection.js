devise.define(['jquery', 'dvsBaseView', 'dvsFieldView'], function($, View, FieldView)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'click #dvs-sidebar-manage-groups': 	'showManageView',
		'click .js-show-grids-view': 			'showGridView',
		'click #dvs-new-collection-instance': 	onNewCollectionInstanceBtnClicked,
		'change #dvs-groups-select': 			onSelectedInstanceChanged,
		'click [data-show-field]': 				onShowFieldBtnClicked,
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
		this.groupSelector = null;
		this.field = null;
	};

	/**
	 * Handles render method for collection view
	 */
	CollectionView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['instances'] = node.data;

		this.grid = renderGridViews(this.data.instances);
		this.manage = View.make('sidebar.collections.manage', this.data);
		this.groupSelector = View.make('sidebar.collections.selector', this.data);
		this.field = $('<div/>');

		this.sidebar.breadcrumbsView.add('All Editors', this, 'showGridView');
		this.sidebar.grid.append(this.grid);
		this.sidebar.groupSelector.append(this.groupSelector);
		this.sidebar.manageCollection.append(this.manage);
		this.sidebar.manageCollection.show();

		View.registerEvents(this.grid, events, this);
		View.registerEvents(this.manage, events, this);
		View.registerEvents(this.groupSelector, events, this);

		if (this.data.instances.length == 0) this.showManageView();
		else this.showGridView();

		return this.field;
	};

	/**
	 * handles the closing of this view to
	 * prevent memeory leaks
	 */
	CollectionView.prototype.close = function()
	{
		this.grid = null;
		this.manage = null;
		this.groupSelector = null;
		this.field = null;
	}

	/**
	 * shows the collection field in our sidebar view
	 */
	CollectionView.prototype.showCollectionField = function(fieldId, instanceId)
	{
		// var fieldView = new FieldView(this.data.page);
		// var field = this.findCollectionField(fieldId, instanceId);
		// var html = fieldView.renderField(field);

		// this.field.empty();
		// this.field.append(html);
		// this.field.show();
		// this.grid.hide();
		// this.sidebar.saveButton.show();
	}

	/**
	 * Shows the grid view for a given instance
	 */
	CollectionView.prototype.showGridView = function()
	{
		this.manage.hide();
		this.grid.show();
	}

	/**
	 * Shows the create instance view
	 */
	CollectionView.prototype.showManageView = function()
	{
		this.sidebar.breadcrumbsView.add('Collections', this, 'showManageView');
		this.grid.hide();
		this.manage.show();
	}

	/**
	 * the selected instance has been changed, we need to change
	 * our data nodes and refresh the views
	 */
	CollectionView.prototype.updateSelectedInstance = function(instanceId)
	{
		console.log('update the selected instance');
		// this.manageView.hide();
		// this.breadcrumbsView.hide();
		// this.fieldView.hide();
		// this.saveButtonView.hide();
		// this.gridsView.find('li').removeClass('dvs-active');
		// this.gridsView.find('#dvs-sidebar-elements-and-groups-' + instanceId + ' > li').addClass('dvs-active');
		// this.gridsView.show();
	}

	/**
	 * save the collection...
	 */
	CollectionView.prototype.save = function()
	{
		console.log('save the collection now', this.data);
	}

	/**
	 * called when our form content changes
	 */
	CollectionView.prototype.changed = function(event)
	{
		console.log('content changed inside of this collection...');
	}

	/**
	 * loops through all the instances of this collection
	 * view and spits out crap for it. we also render
	 * an empty view in case no instances are found
	 */
	function renderGridViews(instances)
	{
		var view = "";

		$.each(instances, function(index, instance)
		{
			view += View.render('sidebar.collections.grid', instance);
		});

		return view;
	}

	/**
	 * The event is triggered when the user
	 * picks a different instance from the
	 * drop down list
	 */
	function onSelectedInstanceChanged(event)
	{
		var selected = $(event.currentTarget);

		if (selected.val()) {
			this.updateSelectedInstance(selected.val());
		}
	}

	/**
	 * Show the field when this button is clicked
	 */
	function onShowFieldBtnClicked(event)
	{
		var button = $(event.currentTarget);
		var fieldId = button.data('showField');
		var collectionInstanceId = button.data('collectionInstance');
		// this.showCollectionField(fieldId, collectionInstanceId);
		console.log('show the field btn', fieldId, collectionInstanceId);
	}

	/**
	 * add a new collection instance to the database
	 */
	function onNewCollectionInstanceBtnClicked(event)
	{
		console.log('add new collection instance', event);
	}

	return CollectionView;
});