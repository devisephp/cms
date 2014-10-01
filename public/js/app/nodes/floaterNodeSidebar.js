define(['require', 'jquery'], function (require, $) {


    var floaterNodeSidebar = {
        init: function() {
            drawSidebar();
        },
        openSidebar: function(_nodes) {
            clearNodes();
            addNodes(_nodes);
            $('#dvs-floater-node-sidebar').addClass('active');
        },
        closeSidebar: function() {
            $('#dvs-floater-node-sidebar').removeClass('active');
        }
    };

    function drawSidebar() {
        var _sidebar = $('<div>')
            .attr('id', 'dvs-floater-node-sidebar');
        var _ul = $('<ul>');

        _sidebar.append(_ul);

        $('#dvs-mode').append(_sidebar);
    }

    function clearNodes() {
        $('#dvs-floater-node-sidebar').children('ul').html('');
    }

    function addNodes(_nodes) {
        var _sidebarUl = $('#dvs-floater-node-sidebar').children('ul');

            $.each(_nodes, function (index, node) {

                node.coordinates = {left: 0, top: 0}

                var _li = $('<li>')
                    .addClass('dvs-node')
                    .html(node.label)

                _li.data('dvsData', node);

                _sidebarUl.append(_li);
            });
    }

    return floaterNodeSidebar;

});