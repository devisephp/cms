devise.define(['jquery', 'dvsBaseView', 'dvsFieldView'], function($, View, FieldView)
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

		this.view = this.fieldView.renderField(this.data.field);

		View.registerEvents(this.view, events, this);

		return this.view;
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
	AttributeView.prototype.save = function()
	{
		console.log('save the attribute now', this.data.field);
	}

	/**
	 * called when our form content changes
	 */
	AttributeView.prototype.changed = function(event)
	{
		console.log('content changed inside of this attribute...');
	}

	return AttributeView;
});