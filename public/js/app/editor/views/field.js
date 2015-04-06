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

		this.view = $('<div/>');

		this.view.append(this.renderField(node.data, true));

		this.sidebar.saveButton.show();

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
		var requestContent = View.make('sidebar.partials.request-content', { 'content_requested': field.content_requested });

		var resetValues = View.make('sidebar.partials.reset-values');

		var sitewide = View.make('sidebar.partials.site-wide-field', { 'site_wide': field.scope !== 'page' });

		this.data['field'] = field;

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
		var self = this;
		var url = this.data.page.url('update_field', {id: this.data.field.id});
		var data = {
			'field': this.data.field,
			'page': this.data.page.info
		};

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
	FieldView.prototype.changed = function(key, value, event)
	{
		var field = this.data.field;

		switch (key)
		{
			case 'content_requested':
				field.content_requested = value;
			break;

			case 'field_scope':
				field.new_scope = value ? 'global' : 'page';
			break;

			case '_reset_values':
				this.resetFieldValues(field, value);
			break;

			default: field.values[key] = value;
		}
	}

	/**
	 * reset this fields value if it is okay
	 */
	FieldView.prototype.resetFieldValues = function(field, shouldReset)
	{
		if (!shouldReset) return;

		var self = this;

		setTimeout(function()
		{
			field.values = {};
			self.view.empty();
			self.view.append(self.renderField(field, true));
		}, 500);
	}

	/**
	 * save was successful, update field values
	 * to reflect what is returned from the server
	 */
	function onSaveSuccess(data, response, xhr)
	{
		this.view.empty();
		this.view.append(this.renderField(data, true));
	}

	/**
	 * save failed to update field, probably
	 * should let the user know or something
	 * with validation messages
	 */
	function onSaveError()
	{
		alert('Could not save field! Check console');
		console.warn('save error', this, arguments);
	}

	return FieldView;
});