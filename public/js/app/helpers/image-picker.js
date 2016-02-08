devise.define(['jquery'], function($) {
	$(document).ready(function()
	{
		initImagePicker();
		initImagePreview();
	});

	function initImagePicker()
	{
		$('body').on('click', '.image-picker', function()
	    {
	        var input = $(this);
	        var mediaUrl = '/admin/media-manager?cropMode=Preserve&type=image';
	        window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");

	        document.onMediaManagerSelect = function(images){
	            var preview = input.siblings('img.image-picker-preview');

	            input.val(images);
				hideOrShowPreview(preview, images);
	        };
	    });
	}

	function initImagePreview()
	{
		hideOrShowPreview();
		addImagePickerPreviewListeners();
	}

	function hideOrShowPreview() {
		$('.image-picker').each(function(el){
			var preview = $(this).siblings('img.image-picker-preview');

			if (preview.size() > 0) {
				if ($(this).val() == "") {
		    		preview.css('display', 'none')
		    	} else {
		    		preview.attr('src', $(this).val());
		    		preview.css('display', 'inline-block')
		    	}
		    }
		});
	}

	function addImagePickerPreviewListeners() {
		$('body').on('click', '.image-picker-preview', function() {
			var input = $(this).siblings('.image-picker').trigger('click');
		});
	}
});