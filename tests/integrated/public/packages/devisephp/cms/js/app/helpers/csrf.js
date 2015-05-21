devise.define(['jquery'], function ($)
{
	function updateToken(token)
	{
	    $.ajaxSetup({
	        headers: {
	            'X-XSRF-TOKEN': token
	        }
	    });
	}

	var csrfToken = $('meta[name="csrf-token"]').attr('content');

	if (csrfToken) updateToken(csrfToken);

    return updateToken;
});