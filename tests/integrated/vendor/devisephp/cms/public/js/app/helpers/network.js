devise.define(['require', 'jquery', 'dvsPageData'], function (require, $, dvsPageData) {

    var target;
    var callback;
    var data;

    var network = {
        insertTemplate: function(_view, _target, _data, _callback) {

            buildCollectionData(_data);

            _data['page_id'] = $('#dvs-mode').data('dvs-page-id');
            _data['page_version_id'] = $('#dvs-mode').data('dvs-page-version-id');

            var data = {
                _token: dvsPageData.csrf_token,
                view: _view,
                data: _data
            };

            var _sidebarPartialsPath = dvsPageData.url('sidebar_partials') + 'sidebar';

            network.request(_sidebarPartialsPath, data, 'POST', _target, _callback);
        },
        insertElement: function(_data, _target, _callback) {

            var data = {
                _token: dvsPageData.csrf_token,
                data: _data
            };

            var _elementPath = dvsPageData.url('sidebar_partials') + 'element';

            network.request(_elementPath, data, 'POST', _target, _callback);
        },
        reloadElementGrid: function(_data, _target) {

            var data = {
                _token: dvsPageData.csrf_token,
                data: _data
            };

            var _elementGridPath = dvsPageData.url('sidebar_partials') + 'element-grid';

            network.request(_elementGridPath, data, 'POST', _target);
        },
        request: function(_url, _data, _method, _target, _callback) {
            if (_data)
            {
                if (typeof _data === 'object') _data['_token'] = dvsPageData.csrf_token;
                else _data += '&_token=' + dvsPageData.csrf_token;
            }
            else
            {
                _data = {_token: dvsPageData.csrf_token};
            }

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