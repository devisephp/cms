devise.define(['require', 'jquery'], function (require, $) {

    var init = function(pageVersion) {
        if(typeof pageVersion.preview_message !== 'undefined') {
            var message = createMessage(pageVersion);

            appendMessage(message);

            addListeners();
        }
    };

    function createMessage(pageVersion) {
        var _container = $('<div>').addClass('dvs-preview-status');
        var _title = $('<strong>').html('Attention');
        var _message =  $('<p>').html(pageVersion.preview_message.message);

        if(typeof pageVersion.preview_message.warning !== 'undefined') {
            _container.addClass('dvs-warning');
            _title.html('Warning');
        }

        _container.append(_title);
        _container.append(_message);

        return _container;
    }

    function appendMessage(message) {
        $('body').append(message);
    }

    function addListeners() {
        $('.dvs-preview-status').click(function() {
            $(this).remove();
        });
    }

    return init;

});