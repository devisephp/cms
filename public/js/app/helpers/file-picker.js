devise.define(['jquery'], function($) {
	$(document).ready(function()
	{
		initFilePicker();
	});

	function initFilePicker()
	{
		$('body').on('click', '.file-picker', function()
	    {
	        var input = $(this);
	        var mediaUrl = '/admin/media-manager';

	        window.open(mediaUrl, 'Media Manager', "width=1024,height=768");

	        document.onMediaManagerSelect = function(images){
	            input.val(images);
	        };
	    });
	}
});