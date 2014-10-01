/**
 * Usage: throttle(funcName, 5000)
 */
define([], function()
{
	return function (func, threshold)
	{
		var timeout = false;

	    return function throttle()
	    {
	        var obj = this, args = arguments;

	        function delayed()
	        {
				func.apply(obj, args);
	            timeout = false;
	        };

	        // stop any current detection period
	        if (timeout !== false) clearTimeout(timeout);

	        timeout = setTimeout(delayed, threshold);
	    };
	}
});

