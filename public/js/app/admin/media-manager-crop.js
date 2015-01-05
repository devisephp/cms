devise.define(['require', 'jquery', 'app/helpers/query-params', 'jcrop'], function (require, $, queryParams)
{
    var width = $('input[name="cropper[width]"]').val();
    var height = $('input[name="cropper[height]"]').val();
    var jcrop_api;

    var config = {
        bgColor: 'clear',
        aspectRatio: width / height,
        onSelect: onChange,
        onChange: onChange,
        setSelect: [0, 0, width, height]
    };

    var cropper = $('.crop-container img').Jcrop(config, function(){
        jcrop_api = this;
    });

    $('input[name="cropper[width]"]').on('keyup', onDimChange);
    $('input[name="cropper[height]').on('keyup', onDimChange);
    $('form').on('submit', onSubmit);

    function onSubmit(e)
    {
        var target = queryParams('target');
        var url = queryParams('image');
        var crop = {
            width: $('input[name="cropper[width]"]').val(),
            height: $('input[name="cropper[height]"]').val(),
            x: $('input[name="cropper[x]"').val(),
            y: $('input[name="cropper[y]"').val(),
            x2: $('input[name="cropper[x2]"').val(),
            y2: $('input[name="cropper[y2]"').val(),
            w: $('input[name="cropper[w]"').val(),
            h: $('input[name="cropper[h]"').val()
        };

        opener.document.onMediaManagerSelect(url, target, {crop: crop});

        window.close();

        return false;
    }

    function onDimChange(e)
    {
        var width = $('input[name="cropper[width]"]').val();
        var height = $('input[name="cropper[height]"]').val();
        jcrop_api.setOptions({aspectRatio: width / height});
    }

    function onChange(c)
    {
        for(var key in c)
        {
            $('input[name="cropper[' + key + ']"]').val(c[key]);
        }
    }
});