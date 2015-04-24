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
	LiveUpdate.prototype.setup = function(iframe, bindings, database)
	{
		this.iframe = iframe;
		this.bindings = bindings;
		this.database = database;
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
	 * sets the default values set for this field
	 * this only works for values not set inside of this
	 * field
	 */
	LiveUpdate.prototype.setDefaultsForField = function(field)
	{
		var defaults = this.getDefaultsForField(field);

		for (var attribute in defaults)
		{
			if (typeof field.values[attribute] === 'undefined' || !field.values[attribute])
			{
				field.values[attribute] = defaults[attribute];
			}
		}
	}

	/**
	 * finds all the defaults that are in the system for this
	 */
	LiveUpdate.prototype.getDefaultsForField = function(field)
	{
		var defaults = {};
		var fieldKey = _key(field, '');

		for (var key in this.database)
		{
			if (key.match(fieldKey))
			{
				var attribute = key.replace(fieldKey, '');
				defaults[attribute] = this.database[key];
			}
		}

		return defaults;
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