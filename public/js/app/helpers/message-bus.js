define([], function()
{
	return function()
	{
		this._commands = {};

		this._requests = {};

		this.addCommand = function(name, handler)
		{
			this._commands[name] = handler;
		}

		this.addRequest = function(name, handler)
		{
			this._requests[name] = handler;
		}

		this.execute = function(name, args)
		{
			if (arguments.length > 2) args = [].splice.call(arguments, 1);

			if (typeof this._commands[name] !== 'undefined')
			{
				this._commands[name].apply(this, args);
			}
		}

		this.request = function(name, args)
		{
			if (arguments.length > 2) args = [].splice.call(arguments, 1);

			if (typeof this._requests[name] === 'undefined')
			{
				return this._requests[name].apply(this, args);
			}

			throw 'Request lookup failed for name: ' + name;
		}

		return this;
	}
});