devise.define(['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsSelectSurrogate', 'jquery-ui'], function($, View, FieldView, dvsSelectSurrogate)
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
	CollectionView.prototype.save = function()
	{
		var self = this;
		var url = this.data.page.url('update_collection_field', {id: this.selectedField.id});
		var data = {
			'field': this.selectedField,
			'page': this.data.page.info
		};

		$.ajax(url, {
			method: 'PUT',
			data: data,
			success: function(data, response, xhr)
			{
				self.data.field = data;
				console.log(data);
				// LiveUpdater.changedFieldAttribute(this.data.field, key);
				self.renderCollectionField();
			},
			error: function(xhr, textStatus, error)
			{
				alert('Could not save field! Check console');
				console.warn('save error', arguments);
			}
		});
	}

	/**
	 * called when our form content changes
	 */
	CollectionView.prototype.changed = function(key, value, event)
	{
		this.selectedField.values[key] = value;
		LiveUpdater.changedFieldAttribute(this.data.field, key);
	}

	/**
	 * called when reset values is called
	 */
	CollectionView.prototype.resetValuesChanged = function(shouldReset, event)
	{
		if (!shouldReset) return;

		var self = this;

		setTimeout(function()
		{
			self.data.field.values = {};
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
		var data = {};

		$.ajax(url, {
			method: 'POST',
			data: data,
			success: function()
			{
				self.data.instances.splice(instanceIndex, 1);	// remove from instances array
				self.renderInstanceSelectorView();
				self.renderManageView();
			},
			error: function()
			{
				alert('could not remove instance at this time');
				console.warn('could not remove instance at this time', arguments);
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

		$.ajax(url, {
			method: 'POST',
			data: instance,
			success: function(data)
			{
				self.data.instances[instanceIndex] = data;
				self.renderInstanceSelectorView();
				self.renderManageView();
			},
			error: function()
			{
				alert('could not add instance at this time');
				console.warn('could not add instance at this time', arguments);
				self.data.instances.splice(instanceIndex, 1);	// remove from instances array
				self.renderManageView();
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