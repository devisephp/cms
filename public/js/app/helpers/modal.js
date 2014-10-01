define(['require', 'jquery'], function (require, $) {

    var target = null;

    var initialize = function (_target) {
        target = _target;

        $(target).click(launchModal);
    }

    var launchModal = function(e) {
        e.preventDefault();

        var attributeTarget = $(this).data('dvs-modal-target');
        var attributeUrl = $(this).data('dvs-modal-url');
        var hrefTarget = $(this).attr('href');

        if (typeof attributeTarget != 'undefined') {
            loadTarget(attributeTarget);
        } else if (typeof attributeUrl != 'undefined') {
            loadUrl(attributeUrl);
        } else if (typeof hrefTarget != 'undefined') {
            loadUrl(hrefTarget);
        }
    };

    var loadTarget = function(target) {
        var _html = $(target).html();
        insertContent(_html);
    };

    var loadUrl = function(target) {
        var _call = $.ajax({
            url: target,
            method: 'GET'
        });

        _call.done(insertContent);
        _call.fail(loadFailed);
    };

    var insertContent = function(msg) {
        $('#dvs-modal').html(msg);
    };

    var loadFailed = function(jqXHR, textStatus) {
        //console.log(textStatus);
    };

    return initialize;
});