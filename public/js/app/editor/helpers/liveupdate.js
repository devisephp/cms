devise.define(['jquery', 'query'], function($, query)
{
	/**
	 * Create a new live update class
	 */
	var LiveUpdate = function()
	{
		this.iframe = $('<iframe />');
		this.bindings = [];
		this.bindings.apply = function() {};
		this.bindings.get = function(key) {};
		this.bindings.set = function(key, value) {};
	}

	/**
	 * Set the iframe for this live updater
	 */
	LiveUpdate.prototype.setup = function(iframe, bindings)
	{
		this.iframe = iframe;
		this.bindings = bindings;
	}

	/**
	 * Change the bindings database...
	 */
	LiveUpdate.prototype.changedFieldAttribute = function(field, attribute)
	{
		var key = _key(field, attribute);
		var value = _value(field, attribute);

		console.log(field, attribute, key, value);
		this.bindings.set(key, value);
		this.bindings.apply(key);
	}

	/**
	 * update a bunch of values all at once using
	 * the entire field
	 */
	LiveUpdate.prototype.changedField = function(field)
	{
		for (var key in field.values)
		{
			this.changedFieldAttribute(field, key);
		}
	}

	/**
	 * Occasionally it makes sense to refresh the entire
	 * iframe so that we get a new updated view...
	 */
	LiveUpdate.prototype.refresh = function()
	{
		typeof this.iframe[0] !== 'undefined' &&
		typeof this.iframe[0].contentWindow !== 'undefined' &&
		typeof this.iframe[0].contentWindow.location !== 'undefined' &&
		typeof this.iframe[0].contentWindow.location.reload !== 'undefined' &&
		this.iframe[0].contentWindow.location.reload(true);
	}

	/**
	 * unique key for this field and attribute
	 */
	function _key(field, attribute)
	{
		return field.scope + '-' + field.id + '-' + attribute;
	}

	/**
	 * value for this field and attribute pair
	 */
	function _value(field, attribute)
	{
		return field.values[attribute];
	}

	return LiveUpdate;
});