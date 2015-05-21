devise.define(['jquery', 'throttle', 'dvsReplacement'], function ($, throttle, dvsReplacement)
{
	$('body').on('keyup change', '[data-dvs-replacement]', throttle(dvsReplacement(), 250));

});
