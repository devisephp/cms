devise.define(['jquery', 'dvsBaseView', 'dvsFieldView'], function($, View, FieldView)
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

		this.field = $('<div/>');
		this.grid = View.make('sidebar.creators.grid', this.data);

		this.sidebar.breadcrumbsView.add(node.human_name, this, 'showGridView');
		this.sidebar.grid.append(this.grid);

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
		var field = this.createFieldFor(name);
		var html = fieldView.renderField(field);

		this.sidebar.breadcrumbsView.add(name, this, 'showFieldView', [name]);

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
	 * creates an empty field for this mapping name
	 */
	CreatorView.prototype.createFieldFor = function(name)
	{
		var field = {};

		var defaults = {};

		this.data.attributes[name] = typeof this.data.attributes[name] === 'undefined' ? defaults : this.data.attributes[name];

		field.collection_instance_id = null;
		field.page_version_id = this.sidebar.page.pageVersionId;
		field.type = this.data.creator.types[name];
		field.human_name = name;
		field.key = this.data.creator.id;
		field.values = this.data.attributes[name];
		field.scope = 'model';
		field.content_requested = false; 

		return field;
	}

	/**
	 * save the field...
	 */
	CreatorView.prototype.save = function()
	{
		console.log('save the creator now', this.data);
	}

	/**
	 * called when our form content changes
	 */
	CreatorView.prototype.changed = function(event)
	{
		console.log('content changed inside of this creator...');
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