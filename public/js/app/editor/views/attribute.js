devise.define(['jquery', 'dvsBaseView', 'dvsFieldView', 'dvsLiveUpdater'], function($, View, FieldView, LiveUpdater)
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
		this.sidebar.validationErrors.empty();
		this.sidebar.validationErrors.append(html);
	}

	return AttributeView;
});