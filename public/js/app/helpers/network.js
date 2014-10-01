define(['require', 'jquery'], function (require, $) {

    var target;
    var callback;
    var data;

    var network = {
        insertTemplate: function(_view, _target, _data, _callback) {
            _data['page_id'] = $('#dvs-mode').data('dvs-page-id');

            buildCollectionData(_data);

            var data = {
                view: _view,
                data: _data
            };

            var _partialPath = requirejs.s.contexts._.config.devise.partialLoaderPath;

            network.request(_partialPath, data, 'POST', _target, _callback);
        },
        request: function(_url, _data, _method, _target, _callback) {

            data = _data

            target = _target;
            callback = _callback;

            var _request = $.ajax({
                url: _url,
                type: _method,
                data: _data,
            });

            _request.done(handleTemplateLoadDone);
            _request.fail(handleTemplateLoadFail);
        }
    };

    function buildCollectionData(_data) {
        if (typeof _data.collection !== 'undefined' && _data.collection !== '' && _data.collection !== null) {

            _data[_data.collection] = [];

            $.each(_data.groups, function (groupName, group) {
                $.each(group, function (index, g) {
                    _data[_data.collection].push(g);
                });
            });
        }
    }

    function handleTemplateLoadDone( msg ) {
        $(target).html(msg.html);
        callback('done', msg, data);
    }

    function handleTemplateLoadFail( jqXHR, textStatus ) {
        callback('fail');
    }

    return network;

});