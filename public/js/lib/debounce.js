/**
 * Usage: debounce(funcName, 500)
 */
define([], function()
{
	return function (func, threshold)
	{
	    var timeout;

	    return function debounced()
	    {
	        var obj = this, args = arguments;

	        function delayed()
	        {
				func.apply(obj, args);
	            timeout = null;
	        };

	        // stop any current detection period
	        if (timeout) clearTimeout(timeout);

	        // otherwise, if we're not already waiting and we're executing at the beginning of the detection period
	        else func.apply(obj, args);

	        timeout = setTimeout(delayed, threshold);
	    };
	}
});

