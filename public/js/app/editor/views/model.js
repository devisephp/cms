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

		this.sidebar.breadcrumbsView.add(node.human_name, this, 'showModelView');
		this.sidebar.grid.append(this.grid);

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
		var fieldView = new FieldView(this.sidebar);
		var field = View.data.find(this.data.fields, fieldId);
		var html = fieldView.renderField(field);

		this.sidebar.breadcrumbsView.add(field.mapping, this, 'showModelFieldView', [fieldId]);

		this.field.empty();
		this.field.append(html);
		this.field.show();
		this.grid.hide();
		this.sidebar.saveButton.show();
	}

	/**
	 * Shows the model view
	 */
	ModelView.prototype.showModelView = function()
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
		console.log('save the model now', this.data);
	}

	/**
	 * called when our form content changes
	 */
	ModelView.prototype.changed = function(event)
	{
		console.log('content changed inside of this model...');
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