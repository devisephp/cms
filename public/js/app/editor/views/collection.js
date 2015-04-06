devise.define(['jquery', 'dvsBaseView', 'dvsFieldView', 'jquery-ui'], function($, View, FieldView)
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
		'click [data-remove-instance-id]': 		onRemoveInstanceClicked,
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

		this.grid = this.renderGridView();
		this.manage = this.renderManageView();
		this.groupSelector = this.renderGroupSelectorView();
		this.field = $('<div/>');

		this.sidebar.breadcrumbsView.add('All Editors', this, 'showGridView');
		this.sidebar.grid.append(this.grid);
		this.sidebar.groupSelector.append(this.groupSelector);
		this.sidebar.manageCollection.append(this.manage);
		this.sidebar.manageCollection.show();

		View.registerEvents(this.grid, events, this);
		View.registerEvents(this.manage, events, this);
		View.registerEvents(this.groupSelector, events, this);

		if (this.data.instances.length === 0)
		{
			this.showManageView();
		}

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
		var fieldView = new FieldView(this.sidebar);
		var instance = View.data.find(this.data.instances, instanceId);
		var field = View.data.find(instance.fields, fieldId);
		var html = fieldView.renderField(field);

		this.sidebar.breadcrumbsView.add(field.human_name, this, 'showCollectionField', [fieldId, instanceId]);

		this.field.empty();
		this.field.append(html);
		this.field.show();
		this.manage.hide();
		this.grid.hide();
		this.sidebar.saveButton.show();
	}

	/**
	 * Shows the grid view for a given instance
	 */
	CollectionView.prototype.showGridView = function()
	{
		if (!this.selectedInstanceId) return;

		this.manage.hide();
		this.field.hide();
		this.sidebar.saveButton.hide();
		this.grid.show();
		this.grid.find('li').removeClass('dvs-active');
		this.grid.find('li#dvs-sidebar-group-' + this.selectedInstanceId).addClass('dvs-active');
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
	 * Renders the grid view with this data
	 */
	CollectionView.prototype.renderGridView = function()
	{
		return View.make('sidebar.collections.grid', this.data);
	}

	/**
	 * Renders the manage view with this data
	 */
	CollectionView.prototype.renderManageView = function()
	{
		var view = View.make('sidebar.collections.manage', this.data);

        var sortable = view.filter('#dvs-collection-instances-sortable').sortable({
            axis: 'y',
            stop: function() {
            	console.log('sorting stopped');
            },
            placeholder: 'dvs-sort-placeholder'
        });

        sortable.disableSelection();

		return view;
	}

	/**
	 * Renders the group selector view with this data
	 */
	CollectionView.prototype.renderGroupSelectorView = function()
	{
		return View.make('sidebar.collections.selector', this.data)
	}

	/**
	 * the selected instance has been changed, we need to change
	 * our data nodes and refresh the views
	 */
	CollectionView.prototype.updateSelectedInstance = function(instanceId)
	{
		this.selectedInstanceId = instanceId;
		this.showGridView();
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
		this.showCollectionField(fieldId, collectionInstanceId);
	}

	/**
	 * remove this instance id from the collection set
	 */
	function onRemoveInstanceClicked(event)
	{
		console.log('removing this instance id', event);
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