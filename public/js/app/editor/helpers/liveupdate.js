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

		this.bindings.set(key, value);
		this.bindings.apply(key);
	}

	/**
	 * update a bunch of values all at once using
	 * the entire field
	 */
	LiveUpdate.prototype.changedField = function(field)
	{
		for (var attribute in field.values)
		{
			this.changedFieldAttribute(field, attribute);
		}
	}

	/**
	 * Update all of the attributes for this field
	 */
	LiveUpdate.prototype.changedModel = function(field)
	{
		for (var attribute in field.values)
		{
			this.changedModelAttribute(field, attribute);
		}
	}

	/**
	 * update this key inside of this field
	 */
	LiveUpdate.prototype.changedModelAttribute = function(field, attribute)
	{
		var key = _model_key(field, attribute);
		var value = _value(field, attribute);

		if (key)
		{
			this.bindings.set(key, value);
			this.bindings.apply(key);
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
	 * unique key for model field types
	 */
	function _model_key(field, attribute)
	{
		var pick = false;
		var type = field.model_type;
		var id = field.model_id;

		for (var index in field.picks)
		{
			if (field.picks[index] === attribute)
			{
				pick = index;
				break;
			}
		}

		return pick ? type + '-' + id + '-' + pick : false;
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