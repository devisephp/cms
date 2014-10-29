define(['jquery', 'dvsNodeView', 'dvsFloaterSidebar', 'dvsSidebarView', 'dvsCollectionsView', 'dvsAdminView', 'dvsPageData'], (function( $, nodeView, floaterNodeSidebarView, sidebarView, collectionsView, adminView, pageData ) {

    var savingCount = 0;
    var node = null;
    var sidebarListenersAdded = false;

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    function initialize() {
        $('body').on('dvsCloseAdmin', '#dvs-mode', function(){
            closeAdmin();
        });
    }

    var listeners = {
        addEditorListeners: function() {

            $('#dvs-node-mode-button').click(function() {

                if(!$('#dvs-mode').hasClass('dvs-node-mode')) {
                    nodeView();
                    floaterNodeSidebarView.init();
                    addNodeListeners();
                    addFloaterNodeListeners();
                } else {
                    closeAdmin();
                }
            });
        },

        addBlockerListener: function() {
            $('#dvs-blocker').click(function() {
                closeAdmin();
            });
        },

        addSidebarListeners: function(_data) {

            if(!sidebarListenersAdded) {
                $('#dvs-sidebar').on('sidebarLoaded', function () {
                    addSidebarGroupsChangeListener();
                    addSidebarSaveListener();
                    addSidebarLanguageListener();
                    listeners.addCollectionsListeners();
                });
            }

            $('#dvs-sidebar').on('sidebarUnloadedLoaded', function () {
                listeners.removeCollectionsListeners();
            });

            sidebarListenersAdded = true;

        },

        addCollectionsListeners: function() {

            console.log('good - addCollectionsListeners');

            if (typeof node.collection !== "undefined" && node.collection !== '' && node.collection !== null) {

                console.log('bad - addCollectionsListeners');

                $('#dvs-sidebar-collections').on('click', '#dvs-new-collection-instance', function(){
                    collectionsView.addCollection();
                });
                $('#dvs-sidebar-collections').on('click', '.dvs-collection-instance-remove', function(){
                    var _el = $(this);
                    var _id = $(this).data('id');

                    collectionsView.removeCollection(_el, _id);
                });

                $('#dvs-sidebar-collections').on('keyup', 'input.dvs-collection-instance-name', function(){
                    var _val = $(this).val();
                    var _id = $(this).attr('name').substr(3);

                    delay(function(){
                        collectionsView.updateInstanceName(_id, _val);
                    }, 1000 );
                });

                collectionsView.init();
            }
        },

        removeCollectionsListeners: function() {

            if (typeof node.collection !== "undefined" && node.collection !== '' && node.collection !== null) {
                $('#dvs-mode').off('click', '#dvs-new-collection-instance');
                $('#dvs-sidebar-collections').off('keyup', 'input.dvs-collection-instance-name');
            }
        }
    };

    function addLoader(_msg) {
        // Only add the loader if it isn't there already
        if (!$('.dvs-loading').length) {
            var _loader = $('<div>').addClass('dvs-loading onload').html(_msg);
            $('#dvs-mode').append(_loader);
            $('.dvs-loading').removeClass('onload');
        }
    }

    function removeLoader() {
        $('.dvs-loading').remove();
    }

    function addToSavingCount() {
        savingCount++;
        addLoader('Saving, please wait a moment');
    }

    function removeFromSavingCount() {
        savingCount--;
        removeLoader();
    }

    function addSidebarLanguageListener() {
        $('#dvs-sidebar-language-selector').change(function(){
            window.location = $(this).val();
        });
    }

    function addSidebarSaveListener() {
        $('#dvs-sidebar .dvs-sidebar-save-group').click(function (evt) {
            $(this).closest('.dvs-sidebar-elements').find('form').each(function () {

                var config = {continue: true};
                $(this).trigger('beforeSave', [config]);

                addToSavingCount();

                if (config.continue) {
                    var data = $(this).serialize();
                    var url = $(this).attr('action');

                    // always pass in page_ids so we can restore
                    // fields from global to page version level if needed
                    data = data + '&page_version_id=' + pageData.page_version_id;
                    data = data + '&page_id=' + pageData.page_id;

                    $.ajax({
                        url: url,
                        data: data,
                        type: 'post',
                        success: function () {
                            removeFromSavingCount();
                        },
                        error: function () {
                            alert('There was a problem saving these fields')
                        }
                    });
                }
            });
        });
    }

    function addSidebarGroupsChangeListener() {
        $('#dvs-sidebar-groups').change(function () {
            var _selectedGroup = $(this).val();

            $('.dvs-sidebar-group').removeClass('active');
            $('#dvs-sidebar-group-' + _selectedGroup).addClass('active');

            $(".dvs-accordion").accordion("refresh");

            $('.dvs-fat-sidebar').click(function () {
                fattenUp();
            });
        });
    }

    function addNodeListeners() {
        $('.dvs-node').click(function() {
            var _node = $(this).data('dvsData');
            node = _node;

            closeAdmin();
            openSidebar(_node);
        });
    }

    function addFloaterNodeListeners() {
        $('#dvs-mode').on('click', '#dvs-floater-node', function(){
            var _floaterNodes = $('#dvs-floater-node').data('nodes');

            floaterNodeSidebarView.openSidebar(_floaterNodes);
            addNodeListeners();
        });
    }

    function closeAdmin()
    {
        $('#dvs-mode').removeClass('dvs-node-mode dvs-admin-mode dvs-sidebar-mode');
        $('#dvs-nodes').html('');
        $('#dvs-node-mode-button').html('Edit Page');
        floaterNodeSidebarView.closeSidebar();
        $('#dvs-mode').trigger('closeAdmin');
    }

    function openSidebar(node)
    {
        sidebarView.init(node);

        $('#dvs-mode')
            .removeClass('dvs-node-mode dvs-admin-mode')
            .addClass('dvs-sidebar-mode');

        listeners.addBlockerListener();
        listeners.addSidebarListeners();
    }

    initialize();

    return listeners;

}));
