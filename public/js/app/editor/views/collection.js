devise.define(['jquery', 'dvsBaseView', 'dvsFieldView'], function($, View, FieldView)
{
	/**
	 * List of events for this view
	 */
	var events = {
		'click #dvs-sidebar-manage-groups': 'showManageView',
		'click .js-show-grids-view': 		'showGridsView',
		'change #dvs-groups-select': 		onSelectedInstanceChanged,
		'click [data-show-field]': 			onShowFieldBtnClicked,
	};

	/**
	 * Constructor for collection view
	 */
	var CollectionView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.layout = null;
	};

	/**
	 * Handles render method for collection view
	 */
	CollectionView.prototype.render = function(node)
	{
		this.data['node'] = node;
		this.data['instances'] = node.data;

		this.layout = View.make('sidebar.collections.layout', this.data);

		// this.headerView = this.layout.filter('[data-view="header"]');
		// this.gridsView = this.layout.filter('[data-view="grids"]');
		// this.breadcrumbsView = this.layout.filter('[data-view="breadcrumbs"]');
		// this.manageView = this.layout.filter('[data-view="manage"]');
		// this.selectedInstanceView = this.layout.filter('[data-view="selected-instance"]');
		// this.fieldView = this.layout.find('[data-view="field"]');
		// this.saveButtonView = this.layout.find('[data-view="save-button"]');

		// this.gridsView.append(renderGridViews(this.data.instances));
		// this.manageView.append(View.make('sidebar.collections.manage'), this.data);
		// this.headerView.append(View.make('sidebar.collections.header', this.data));

		View.registerEvents(this.layout, events, this);

		return this.layout;
	};

	/**
	 * handles the closing of this view to
	 * prevent memeory leaks
	 */
	CollectionView.prototype.close = function()
	{
		this.sidebar = null;
		this.data = null;
		this.layout = null;

	}

	/**
	 * shows the collection field in our sidebar view
	 */
	CollectionView.prototype.showCollectionField = function(fieldId, instanceId)
	{
		var fieldView = new FieldView(this.data.page);
		var field = this.findCollectionField(fieldId, instanceId);
		var html = fieldView.renderField(field);

		this.fieldView.empty();
		this.fieldView.append(html);
		this.fieldView.show();
		this.gridsView.hide();
		this.saveButtonView.show();
	}

	/**
	 * Shows the grid view for a given instance
	 */
	CollectionView.prototype.showGridsView = function()
	{
		this.breadcrumbsView.empty();
		this.breadcrumbsView.hide();
		this.manageView.hide();
		this.gridsView.show();
	}

	/**
	 * Shows the create instance view
	 */
	CollectionView.prototype.showManageView = function()
	{
		var breadcrumbsView = View.make('sidebar.collections.breadcrumbs-manage');
		this.breadcrumbsView.empty();
		this.breadcrumbsView.append(breadcrumbsView);
		this.breadcrumbsView.show();
		this.gridsView.hide();
		this.manageView.show();
	}

	/**
	 * the selected instance has been changed, we need to change
	 * our data nodes and refresh the views
	 */
	CollectionView.prototype.updateSelectedInstance = function(instanceId)
	{
		this.manageView.hide();
		this.breadcrumbsView.hide();
		this.fieldView.hide();
		this.saveButtonView.hide();
		this.gridsView.find('li').removeClass('dvs-active');
		this.gridsView.find('#dvs-sidebar-elements-and-groups-' + instanceId + ' > li').addClass('dvs-active');
		this.gridsView.show();
	}

	/**
	 * finds a collection instance with given id
	 */
	CollectionView.prototype.findCollectionInstance = function(instanceId)
	{
		var found = null;

		$.each(this.data.instances, function(index, instance)
		{
			if (instance.id === instanceId) {
				found = instance;
			}
		});

		return found;
	}

	/**
	 * finds a collection field for a given field id and instance id
	 */
	CollectionView.prototype.findCollectionField = function(fieldId, instanceId)
	{
		var found = null;
		var instance = this.findCollectionInstance(instanceId);

		$.each(instance.fields, function(index, field)
		{
			if (field.id == fieldId) {
				found = field;
			}
		});

		return found;
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
			view += View.render('sidebar.collections.grid-view', instance);
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
		this.updateSelectedInstance(selected.val());
	}

	/**
	 * Show the field when this button is clicked
	 */
	function onShowFieldBtnClicked(event)
	{
		var button = $(event.currentTarget);
		var fieldId = button.data('showField');
		var collectionInstanceId = button.data('collectionInstance');
		this.showCollectionField(fieldId, collectionInstanceId);
	}

	/**
	 * Save the current field that is open
	 */
	function onSidebarSaveButtonClicked(event)
	{
		console.log('save button clicked in collections');
	}

	return CollectionView;
});