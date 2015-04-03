devise.define(['handlebars'], function(handlebars)
{
	/**
	 * store templates in this object
	 */
	var templates = { JST: {} };

	/**
	 * make a new view given viewpath and data
	 */
	templates.make = function(viewpath, data)
	{
		if (typeof this.JST[viewpath] === 'undefined')
		{
			throw viewpath + ' is not a registered template!';
		}

		if (typeof this.JST[viewpath] !== 'function')
		{
			this.JST[viewpath] = handlebars.compile(this.JST[viewpath]);
		}

		return this.JST[viewpath](data);
	};

	/**
	 * register helper for when
	 */
	handlebars.registerHelper('when', function(value, option1, option2) {
		if (value) return option1;

		if (typeof option2 !== 'string') return '';

		return option2;
	});

	/**
	 * register helper for get
	 */
	handlebars.registerHelper('get', function(value, defaultValue) {
		if (value) return value;

		return defaultValue;
	});

	/**
	 * register helper for date formatting
	 */
	handlebars.registerHelper('date', function(currentTime, dateFormat) {
		var date = new Date;

		if (typeof currentTime !== 'undefined' && currentTime !== 'now' && currentTime !== '' && currentTime != false) {
			date = new Date(currentTime);
		}

		if (typeof dateFormat === 'undefined' || dateFormat === '') {
			dateFormat = 'm/d/Y';
		}

		return date.dateFormat(dateFormat);
	});

	/**
	 * register helper for datetime formatting
	 */
	handlebars.registerHelper('datetime', function(currentTime, dateFormat) {
		var date = new Date;

		if (typeof currentTime !== 'undefined' && currentTime !== 'now' && currentTime !== '' && currentTime != false) {
			date = new Date(currentTime);
		}

		if (typeof dateFormat === 'undefined' || dateFormat === '') {
			dateFormat = 'm/d/Y h:i A';
		}

		return date.dateFormat(dateFormat);
	});

	/**
	 * register helper for select
	 */
	handlebars.registerHelper("select", function(value, defaultValue, options) {

		if (typeof options === 'undefined') {
			options = defaultValue;
		} else if (!value) {
			value = defaultValue;
		}

		return options.fn(this).split('\n').map(function(v) {
			var t = 'value="' + value + '"'
			return ! RegExp(t).test(v) ? v : v.replace(t, t + ' selected="selected"')
		}).join('\n')
	});

	/**
	 * register helper for ifType
	 */
	handlebars.registerHelper("ifType", function(object, type, options) {
		if (typeof object === type) {
			return options.fn(this);
		} else {
			return options.inverse(this);
		}
	});

	/**
	 * register helper for checked
	 */
	handlebars.registerHelper("checked", function(value, options) {
		return value ? 'checked' : '';
	});

	/**
	 * register helper for disabled
	 */
	handlebars.registerHelper("disabled", function(value, options) {
		return value ? 'disabled' : '';
	});

	/**
	 * register helper for scripts
	 */
	handlebars.registerHelper("script", function(options) {
		if (options.fn)
			return '<script>' + options.fn(this) + '</script>';

		if (options.hash.src) {
			console.log(options.hash.src);
			return '<script src="'+ options.hash.src +'"></script>';
		}
	});



	/**
	 * return the templates object
	 */
	return templates;
});