devise.define(['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsLiveUpdater'], function($, View, FieldView, LiveUpdater)
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
	CreatorView.prototype.save = function()
	{
		var self = this;
		var url = this.data.page.url('create_model');
		var data = {
			'fields': this.data.fields,
			'page': this.data.page.info
		};

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
		this.showGridView();
		LiveUpdater.refresh();
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