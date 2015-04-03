devise.define(['jquery', 'dvsBaseView'], function($, View)
{
	/**
	 * List of events for this view
	 */
	var events = {

	};

	/**
	 * constructor for creator view
	 */
	var CreatorView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.view = null;
	};

	/**
	 * Renders the entire Creator in the sidebar,
	 * this includes the layout
	 */
	CreatorView.prototype.render = function(node)
	{
		this.data['node'] = node;

		// this.view = View.make('sidebar.creators.layout', this.data);

		// View.registerEvents(this.view, events, this);

		return this.view;
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
	 * close the Creator view
	 */
	CreatorView.prototype.close = function()
	{
		this.data = null;
		this.layout = null;
	}

	return CreatorView;
});