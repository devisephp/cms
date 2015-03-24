devise.define(['require', 'jquery', 'dvsNetwork', 'dvsSidebarView', 'dvsPageData', 'jquery-ui'], function (require, $, network, dvsSidebarView, dvsPageData) {

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
                dvsPageData.url('add_collection_instance', { pageVersionId: pageVersionId, collectionId: collectionId }),
                _data, 'post', null, addSortableItem
            );
        },
        removeCollection: function(_el, _id) {

            network.request(
                dvsPageData.url('remove_collection_instance', { id: _id, collectionId: collectionId }),
                null, 'post', null
            );

            removeCollectionFromDOM(_el);
        },
        updateInstanceName: function(_id, _name) {
            var _data = { name: _name };

            network.request(
                dvsPageData.url('update_collection_instance', { id: _id, pageVersionId: pageVersionId, collectionId: collectionId }),
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

    var addItem = function(_id, _name, _sort, _relatedFields) {
        var _fieldName = 'id-'+_id;
        var _sort = _sort || null;
        var _relatedFields = _relatedFields || null;

        var _input = $('<input>').attr({
            name: _fieldName,
            type: 'text',
            value: _name,
            placeholder: "Instance Name"
        }).addClass('dvs-collection-instance-name');

         // add class "dvs-content-requested" to inputs which
        // are related fields with content requested
        if(checkForContentRequestedFields(_relatedFields) == true) {
            _input.addClass('dvs-content-requested');
        }

        var _link = $('<a>').addClass('dvs-collection-instance-remove').html('&#10006;');
        _link.data('id', _id);

        var _li = $('<li>').attr('id', 'instance_'+_id);

        _li.append(_input);
        _li.append(_link);

        $('#dvs-collection-instances-sortable').append(_li);

        updateGroupSelect(_sort);
    };

    var addSortableItem = function(response, _data) {
        addItem(_data['id'], _data['name'], _data['sort']);

        resetSortable();
        reloadElementGrids();
    };

    var drawSortable = function(response, _data) {
        $.each(_data, function(index, instance) {
            addItem(instance.id, instance.name, null, instance.fields);
        });

        resetSortable();
    };

    var sortingStopped = function() {
        var _data = $('#dvs-collection-instances-sortable').sortable('serialize');

        updateGroupSelect(); // keeps groups select options in sync with sortable list

        network.request(
            dvsPageData.url('sort_collection_instance', { pageVersionId: pageVersionId, collectionId: collectionId }),
            _data, 'post', reloadElementGrids
        );
    };

    function numberOfItemsInCollection() {
        return $('#dvs-collection-instances-sortable').children('li').length;
    }

    function requestSortable() {
        network.request(
            dvsPageData.url('request_sort_collection', { pageVersionId: pageVersionId, collectionId: collectionId }),
            {}, 'get', null, drawSortable
        );
    }

    function reloadElementGrids() {
        var data = dvsSidebarView.currentNodeData();

        data['collection'] = collectionName;
        data['page_version_id'] = pageVersionId;
        data['page_id'] = pageId;

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

    /**
     * Iterates over fields related to collection instance
     * and checks for content_requested equal to "true"
     *
     * @param  {object} _fields  Fields related to collection instance
     * @return {boolean}
     */
    function checkForContentRequestedFields(_fields) {
        var _hasContentRequested = false;

        if(_fields != null) {
            $.each(_fields, function(index, field) {
                if(field.content_requested == '1') {
                    _hasContentRequested = true;
                }
            });
        }

        return _hasContentRequested;
    }

    var updateGroupSelect = function(_sortNum) {
        var _sortNum = _sortNum || null;
        var _el = $('#dvs-sidebar-groups').find('#dvs-groups-select');

        if(_sortNum > 1 || _sortNum === null || _sortNum == 'done') {
            _el.html(''); // empty all select options then start appending
        }

        $('#dvs-collection-instances-sortable li').each(function(key, value) {
            var _option = $('<option value="'+key+'">');
            var _input = $(value).find('input');
            var _value = _input.val();

            // prepend "[ ! ]" to option label
            if(_input.hasClass('dvs-content-requested')) {
                _value = '[ ! ] ' + _value;
            }

            _option.html(_value);
            _el.append(_option);

            // set the styled select/span to the first value's text
            if (key == 0 && _sortNum > 1) {
                $('#dvs-sidebar-groups span.dvs-holder').html(_value);
            }
        });
    };

    return collectionsView;

});