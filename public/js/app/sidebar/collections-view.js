define(['require', 'jquery', 'dvsNetwork', 'dvsSidebarView', 'jquery-ui'], function (require, $, network, dvsSidebarView) {

    var collectionId = null;
    var collectionName = null;
    var pageId = null;
    var pageVersionId = null;
    var sortable = null;

    var collectionsView = {
        init: function() {
            collectionId = $('#dvs-sidebar-collections').data('collection-id');
            collectionName = $('#dvs-sidebar-collections').data('collection-name');
            pageId = $('#dvs-sidebar-collections').data('page-id');
            pageVersionId = $('#dvs-sidebar-collections').data('page-version-id');

            requestSortable();
            initSortable();
        },
        addCollection: function() {
            var _numberOfItems = numberOfItemsInCollection()+1;
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
                _data, 'put', null, updateGroupSelect
            );
        }
    };

    var removeCollectionFromDOM = function(_el) {
        _el.closest('li').remove();
    };

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

        var _link = $('<a>').addClass('dvs-collection-instance-remove').html('&#10006;');
        _link.data('id', _id);

        var _li = $('<li>').attr('id', 'instance_'+_id);

        _li.append(_input);
        _li.append(_link);

        $('#dvs-collection-instances-sortable').append(_li);

        updateGroupSelect();
    };

    var addSortableItem = function(response, _data) {
        addItem(_data['id'], _data['name']);

        resetSortable();
        reloadElementGrids();
    };

    var drawSortable = function(response, _data) {
        $.each(_data, function(index, instance) {
            addItem(instance.id, instance.name);
        });

        resetSortable();
    };

    var sortingStopped = function() {
        var _data = $('#dvs-collection-instances-sortable').sortable('serialize');

        updateGroupSelect(); // keeps groups select options in sync with sortable list

        network.request(
            '/admin/pages/'+ pageVersionId +'/collections/' + collectionId + '/instances/update-sort-orders',
            _data, 'post', reloadElementGrids
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

    function reloadElementGrids() {
        var data = dvsSidebarView.currentNodeData();
        data['collection'] = collectionName;
        data['page_version_id'] = pageVersionId;
        data['page_id'] = pageId;

        console.log(data);

        network.reloadElementGrid(data, '#dvs-sidebar-elements-and-groups');
    }

    function initSortable() {
        sortable = $('#dvs-collection-instances-sortable').sortable({
            axis: 'y',
            stop: sortingStopped,
            placeholder: 'dvs-sort-placeholder'
        });

        sortable.disableSelection();
    }

    function resetSortable() {
        $('#dvs-collection-instances-sortable').sortable('refresh');
    }

    var updateGroupSelect = function() {
        var _el = $('#dvs-sidebar-groups').find('.dvs-select');
        _el.html(''); // empty all select options then start appending

        $('#dvs-collection-instances-sortable li').each(function(key, value){
            var _option = $('<option value="'+key+'">');
            var _value = $(value).find('input').val();

            _option.html(_value);
            _el.append(_option);

            // set span html so styled select displays the first value's text
            if (key == 0) {
                $('#dvs-sidebar-groups span.dvs-holder').html('1) '+_value);
            }
        });
    };

    return collectionsView;

});