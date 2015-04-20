devise.define(['jquery', 'dvsBaseView', 'dvsFieldView'], function($, View, FieldView)
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
		this.grid = View.make('sidebar.models.grid', this.data);
		this.sidebar.grid.append(this.grid);
		this.sidebar.breadcrumbsView.add(node.human_name, this, 'showGridView');

		View.registerEvents(this.grid, events, this);

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
	ModelView.prototype.save = function()
	{
		var self = this;
		var url = this.data.page.url('update_model_fields');
		var data = {
			'fields': this.data.fields,
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
	ModelView.prototype.changed = function(key, value, event)
	{
		this.data.field.values[key] = value;
		LiveUpdater.changedFieldAttribute(this.data.field, key);
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
	 * save was successful, update field values
	 * to reflect what is returned from the server
	 */
	function onSaveSuccess(data, response, xhr)
	{
		this.data.fields = data.fields;
		this.sidebar.breadcrumbsView.back();
		this.showGridView();
		LiveUpdater.changedField(this.data.field);
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
	function onShowModelFieldBtnClicked(event)
	{
		var fieldId = event.currentTarget.dataset.modelFieldId;

		this.showModelFieldView(fieldId);
	}

	return ModelView;
});