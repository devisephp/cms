devise.define(['jquery', 'dvsBaseView'], function($, View)
{
	/**
	 * list of events for this view
	 */
	var events = {

	};

	/**
	 * Constructor for field view
	 */
	var FieldView = function(sidebar)
	{
		this.sidebar = sidebar;
		this.data = { page: sidebar.page };
		this.view = null;
	};

	/**
	 * Renders the entire field in the sidebar,
	 * this includes the layout
	 */
	FieldView.prototype.render = function(node)
	{
		this.data['node'] = node;

		this.view = this.renderField(node.data, true);

		View.registerEvents(this.view, events, this);

		return this.view;
	}

	/**
	 * Render only the field, this excludes the
	 * layout. Because other things use field
	 * view (like collections) then we use this
	 * method for those things.
	 */
	FieldView.prototype.renderField = function(field, showSitewide)
	{
		var requestContent = View.make('sidebar.partials.request-content', { 'request_content': field.request_content });

		var resetValues = View.make('sidebar.partials.reset-values');

		var sitewide = View.make('sidebar.partials.site-wide-field', { 'site_wide': false });

		this.view = View.make('sidebar.fields.' + field.type, { 'page': this.data.page, 'field': field, 'values': field.values });

		this.view.find('[data-view="content-requested"]').replaceWith(requestContent);

		this.view.find('[data-view="reset-values"]').replaceWith(resetValues);

		if (showSitewide) {
			this.view.find('[data-view="site-wide-field"]').replaceWith(sitewide);
		}

		return this.view;
	}

	/**
	 * close the field view
	 */
	FieldView.prototype.close = function()
	{
		this.sidebar = null;
		this.data = null;
		this.view = null;
	}

	/**
	 * save the field...
	 */
	FieldView.prototype.save = function()
	{
		console.log('save the field now', this.data.field);
	}

	/**
	 * called when our form content changes
	 */
	FieldView.prototype.changed = function(event)
	{
		console.log('content changed inside of this field...');
	}

	return FieldView;
});