devise.define(['jquery'], function($) {
	$(document).ready(function()
	{
		initImagePicker();
	});

	function initImagePicker()
	{
		$('body').on('click', '.image-picker', function()
	    {
	        var input = $(this);
	        var image = $(this).siblings('img');

	        var mediaUrl = '/admin/media-manager?cropMode=Preserve&type=image';

	        window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");


	        document.onMediaManagerSelect = function(images){
	            input.val(images);
	            console.log(images);
	            input.attr('src', images);
	        };
	    });
	}
});