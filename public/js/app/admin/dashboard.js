devise.define(['require', 'jquery'], function (require, $, query)
{
	// make entire "dvs-admin-card" into a link
	if($('.dvs-admin-card').length > 0) {
		$('.dvs-admin-card:not(.dvs-page-versions-card)').click(function() {
		    var _url = $(this).data('dvs-url');
		    if (_url != undefined)
		        window.location.href = $(this).data('dvs-url');
		});
	}
});