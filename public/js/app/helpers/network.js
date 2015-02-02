devise.define(['require', 'jquery'], function (require, $) {

    var target;
    var callback;
    var data;
    var partialsPath = devise.requirejs.s.contexts._.config.devise.partialLoaderPath;

    var network = {
        insertTemplate: function(_view, _target, _data, _callback) {

            buildCollectionData(_data);

            _data['page_id'] = $('#dvs-mode').data('dvs-page-id');
            _data['page_version_id'] = $('#dvs-mode').data('dvs-page-version-id');

            var data = {
                view: _view,
                data: _data
            };

            var _sidebarPartialsPath = partialsPath + 'sidebar';

            network.request(_sidebarPartialsPath, data, 'POST', _target, _callback);
        },
        insertElement: function(_data, _target, _callback) {

            var data = {
                data: _data
            };

            var _elementPath = partialsPath + 'element';

            network.request(_elementPath, data, 'POST', _target, _callback);
        },
        reloadElementGrid: function(_data, _target) {

            var data = {
                data: _data
            };

            var _elementGridPath = partialsPath + 'element-grid';

            network.request(_elementGridPath, data, 'POST', _target);
        },
        request: function(_url, _data, _method, _target, _callback) {

            data = _data;

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
        if (typeof _data.collection !== 'undefined' &&
            _data.collection !== '' &&
            _data.collection !== null
            ) {

            _data[_data.collection] = [];

            $.each(_data.groups, function (groupName, group) {
                $.each(group, function (index, g) {
                    _data[_data.collection].push(g);
                });
            });

            if (_data.type == 'model' || _data.type == 'attribute')
            {
                _data.type = 'model_collection';
            }
        }
    }

    function handleTemplateLoadDone( msg ) {
        $(target).html(msg.html);

        if(callback){
            callback('done', msg, data);
        }
    }

    function handleTemplateLoadFail( jqXHR, textStatus ) {
        callback('fail');
    }

    return network;

});