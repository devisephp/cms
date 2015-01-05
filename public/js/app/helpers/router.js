devise.define(['jquery', 'crossroads', 'dvsGlobalBus'], (function($, crossroads, dvsMessageBus)
{
	//
	// Create the router object that will be returned
	//
	var router = function(config)
	{
		config = typeof config === 'undefined' ? {} : config;

		for (var route in config)
		{
			crossroads.addRoute(route, createHandler(route, config[route]));
		}

		return this;
	}

	//
	// Allows us to add additional routes to crossroads
	//
	router.prototype.route = function(route, handler)
	{
		crossroads.addRoute(route, createHandler(route, config[route]));
	}

	//
	// Start the router
	//
	router.prototype.start = function()
	{
		var route = window.location.hash.substr(1);

        if (route == '') return;

        $(window).trigger('hashchange');
	};

	//
	// Create a handler for this route/handler pair
	// since handlers can be strings, functions, etc
	// we need to create them differently
	//
	function createHandler(route, handler)
	{
		var type = $.type(handler);

		switch (type)
		{
			case 'string': return createStringHandler(route, handler);
			case 'array': return createArrayHandler(route, handler);
			case 'function' : return handler;
		}

		throw 'invalid handler provided to route named: ' + route;
	}

	//
	// Creates a function for a string type handlers
	// this lets us do some convention instead of
	// having a lot of functions for routes
	//
	function createStringHandler(route, handler)
	{
		return function()
		{
			var split = handler.split(' ');
			var event = split.shift();
			var selector = replaceValue(split.join(' '), arguments);

			$(selector).trigger(event);
		}
	}

	//
	// Creates a function handler when the handler
	// passed in via the config is an array type
	//
	function createArrayHandler(route, handler)
	{
		return function()
		{
			var name = handler.shift();
			dvsMessageBus.execute(name, replaceValue(handler, arguments));
		}
	}

	//
	// Helper function that finds any replacements
	// in the following values and replaces them.
	// The structure is like {1} would be the first
	// item in the replacements array
	//
	function replaceValue(value, replacements)
	{
		for (var index in replacements)
		{
			var indexPlusOne = parseInt(index) + 1;
			var pattern = new RegExp('\\{' + indexPlusOne + '\\}', 'g');

			if ($.type(value) == 'array')
			{
				for (var i in value)
				{
					value[i] = value[i].replace(pattern, replacements[index]);
				}
			}
			else
			{
				value = value.replace(pattern, replacements[index]);
			}
		}

		return value;
	}

	//
	// Register the hashchange event
	//
	$(window).bind('hashchange', function(event)
	{
		var route = window.location.hash.substr(1);
		crossroads.parse(route);
	});

	//
	// Finally we return the router object
	//
	return router;
}));