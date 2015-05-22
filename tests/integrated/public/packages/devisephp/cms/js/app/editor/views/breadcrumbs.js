devise.define(['jquery', 'dvsBaseView'], function($, View)
{
	/**
	 * Events for the bread crumbs view container
	 */
	var events = {
		'click [data-breadcrumb-id]': onBreadCrumbClicked
	};

	/**
	 * constrcutor for bread crumbs view class
	 */
	var BreadCrumbsView = function()
	{
		this.container = $('<div/>');
		this.breadcrumbs = [];
	}

	/**
	 * adds the container element to this breadcrumbs manager
	 */
	BreadCrumbsView.prototype.setContainerElement = function(element)
	{
		this.container = element;
		View.registerEvents(this.container, events, this);
	}

	/**
	 * add in a new breadcrumb
	 */
	BreadCrumbsView.prototype.add = function(name, context, handler, args)
	{
		if (typeof name !== 'string') {
			throw "cannot add breadcrumb without name";
		}

		if (typeof context !== 'object') {
			throw "cannot add breacrumb without context";
		}

		if (typeof handler !== 'string') {
			throw "cannot add breacrumb without back handler";
		}

		if (typeof args === 'undefined') {
			args = [];
		}

		if (this.breadcrumbs.length > 0) {
			this.breadcrumbs[this.breadcrumbs.length - 1].last = false;
		}

		this.breadcrumbs.push({
			id: this.breadcrumbs.length,
			last: true,
			name: name,
			handler: handler,
			context: context,
			args: args
		});

		this.container.empty();
		this.container.append(this.render());
		this.container.show();
		this.breadcrumbs.length < 2 && this.container.hide();
	}


	/**
	 * runs the back handler for this given index
	 */
	BreadCrumbsView.prototype.back = function(origIndex)
	{
		if (typeof origIndex === 'undefined') {
			origIndex = this.breadcrumbs.length - 2;
		}

		var index = parseInt(origIndex);

		if (isNaN(index) || index > this.breadcrumbs.length - 1 || index < 0) {
			throw "cannot go back to " + origIndex;
		}

		var crumb = this.breadcrumbs[index];
		crumb.context[crumb.handler].apply(crumb.context, crumb.args);

		this.breadcrumbs = this.breadcrumbs.splice(0, index + 1);
		this.breadcrumbs[index].last = true;
		this.container.empty();
		this.container.append(this.render());
		this.breadcrumbs.length < 2 && this.container.hide();
	}

	/**
	 * Renders the breadcrumb breadcrumbs
	 */
	BreadCrumbsView.prototype.render = function()
	{
		return View.make('sidebar.partials.breadcrumbs', {'breadcrumbs': this.breadcrumbs});
	}

	/**
	 * Shows the breadcrumbs container
	 */
	BreadCrumbsView.prototype.show = function()
	{
		this.container.show();
	}

	/**
	 * Hides the breadcrumbs container
	 */
	BreadCrumbsView.prototype.hide = function()
	{
		this.container.hide();
	}

	/**
	 * handles the jquery event for when
	 * a bread crumb is clicked
	 */
	function onBreadCrumbClicked(event)
	{
		var breadcrumbId = event.currentTarget.dataset.breadcrumbId;

		this.back(breadcrumbId);
	}

	/**
	 * Return class for bread crumbs view
	 */
	return BreadCrumbsView;
});