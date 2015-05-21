devise.define(['jquery'], function ($)
{

	$('body').on('click', '[data-change-target][data-value]', function(e)
	{
		var element = $(e.currentTarget);
		var target = element.attr('data-change-target');
		var value = element.attr('data-value');

		$(target).val(value);
		$(target).trigger('change');
	});

});
