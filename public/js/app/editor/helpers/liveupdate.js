devise.define(['jquery', 'query'], function($, query)
{
	var LiveUpdate = function()
	{
		this.iframe = $('<iframe />');
	}

	LiveUpdate.prototype.setIframe = function(iframe)
	{
		this.iframe = iframe;
	}

	LiveUpdate.prototype.refresh = function()
	{
		this.iframe[0].contentWindow.location.reload(true);
	}

	LiveUpdate.prototype.findTarget = function(key)
	{
		// return a target element?
	}

	LiveUpdate.prototype.change = function(target, value)
	{
		// update the stuff on the page?...
	}

	// we need to know two things... the target element and
	// also a handler for how to update the target

	return LiveUpdate;
});