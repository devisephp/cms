define(['require', 'jquery', 'dvsNetwork', 'dvsSidebarView', 'jquery-ui'], function (require, $, network, dvsSidebarView) {

    var collectionId = null;
    var pageId = null;
    var pageVersionId = null;
    var sortable = null;

    var collectionsView = {
        init: function() {
            console.log('in init');

            collectionId = $('#dvs-sidebar-collections').data('collection-id');
            pageId = $('#dvs-sidebar-collections').data('page-id');
            pageVersionId = $('#dvs-sidebar-collections').data('page-version-id');

            requestSortable();
            initSortable();
        },
        addCollection: function() {
            var _numberOfItems = numberOfItemsInCollection()+1;

            console.log(_numberOfItems);

            var _name = $('#dvs-new-collection-instance-name').val();
            var _data = { name: _name, sort: _numberOfItems  };

            network.request(
                '/admin/pages/'+ pageVersionId +'/collections/' + collectionId + '/instances/store',
                _data, 'post', null, addSortableItem
            );
        },
        removeCollection: function(_el, _id) {

            network.request(
                '/admin/collections/' + collectionId + '/instances/'+_id+'/delete',
                null, 'post', null
            );

            removeCollectionFromDOM(_el);
        },
        updateInstanceName: function(_id, _name) {
            var _data = { name: _name };

            network.request(
                '/admin/pages/'+ pageVersionId +'/collections/' + collectionId + '/instances/'+_id+'/update-name',
                _data, 'put', null, updateEditors
            );
        }
    };

    var removeCollectionFromDOM = function(_el) {
        _el.closest('li').remove();
    }

    var updateEditors = function() {
        dvsSidebarView.refresh();
    };

    var addItem = function(_id, _name) {
        var _fieldName = 'id-'+_id;

        var _input = $('<input>').attr({
            name: _fieldName,
            type: 'text',
            value: _name,
            placeholder: "Instance Name"
        }).addClass('dvs-collection-instance-name');

        var _button = $('<button>').addClass('dvs-collection-instance-remove').html('&#10006;');
        _button.data('id', _id);

        var _li = $('<li>').attr('id', 'instance_'+_id);

        _li.append(_input);
        _li.append(_button);

        $('#dvs-collection-instances-sortable').append(_li);
    };

    var addSortableItem = function(response, _data) {

        addItem(_data['id'], _data['name']);
        resetSortable();

        dvsSidebarView.refresh();
    };

    var drawSortable = function(response, _data) {
        $.each(_data, function(index, instance) {
            addItem(instance.id, instance.name);
        });

        resetSortable();
    };

    var sortingStopped = function() {
        var _data = $('#dvs-collection-instances-sortable').sortable( "serialize");

        network.request(
            '/admin/pages/'+ pageVersionId +'/collections/' + collectionId + '/instances/update-sort-orders',
            _data, 'post', null, updateEditors
        );
    };

    function numberOfItemsInCollection() {
        return $('#dvs-collection-instances-sortable').children('li').length;
    }

    function requestSortable() {
        network.request(
            '/admin/pages/'+ pageVersionId +'/collections/' + collectionId + '/instances',
            null, 'get', null, drawSortable
        );
    }

    function initSortable() {
        sortable = $('#dvs-collection-instances-sortable').sortable({ axis: 'y', stop: sortingStopped });
        sortable.disableSelection();
    }

    function resetSortable() {
        $('#dvs-collection-instances-sortable').sortable('refresh');
    }
    return collectionsView;

});