devise.define(['require', 'jquery'], function (require, $) {

    var target = this.target || null;

    var initialize = function (_target) {
        target = _target;
        $(target).click(launchModal);
    };

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

    var closeModal = function() {
        $('#dvs-admin-modal')
            .html('')
            .addClass('dvs-hidden');

        hideBgBlocker();
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
        $('#dvs-admin-modal')
            .toggleClass('dvs-hidden')
            .html(msg);

        showBgBlocker();
    };

    var showBgBlocker = function() {
        $('#dvs-admin-blocker').removeClass('dvs-hidden');
        addCloseListener();
    };

    var hideBgBlocker = function() {
        $('#dvs-admin-blocker').addClass('dvs-hidden');
    };

    var loadFailed = function(jqXHR, textStatus) {
        //console.log(textStatus);
    };

    var addCloseListener = function() {
        $('#dvs-admin-blocker').on('click', function() {
            closeModal();
        });
    };

    return initialize(target);
});