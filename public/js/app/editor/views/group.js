devise.define(['jquery', 'dvsBaseView'], function($, View)
{
	/**
	 * list of events for this view
	 */
	var events = {

	};

	/**
	 * constructor for group view
	 */
	var GroupView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.view = null;
	};

	/**
	 * renders the group in the sidebar
	 */
	GroupView.prototype.render = function(node)
	{
		this.data['node'] = node;
		return this.view;
	}

	/**
	 * close the group view
	 */
	GroupView.prototype.close = function()
	{
		this.data = null;
		this.view = null;
	}

	/**
	 * save the field...
	 */
	GroupView.prototype.save = function()
	{
		console.log('save the group now', this.data);
	}

	/**
	 * called when our form content changes
	 */
	GroupView.prototype.changed = function(event)
	{
		console.log('content changed inside of this group...');
	}

	return GroupView;
});