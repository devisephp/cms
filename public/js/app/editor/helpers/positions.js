devise.define(['jquery'], function($) {
    var nodeHeight = 55;

    /**
     * This calculates the node positions for all
     * the nodes inside of the nodesData
     */
    function calculateNodePositions(nodesView, nodesData)
    {
        nodesView.children().each(function(index, child)
        {
            var cid = $(child).data('node-cid');
            var node = nodesData[cid];
            var body = nodesView.closest('body');

            // groups have nested nodes inside of them
            if (node.binding === 'group')
            {
                for (var i = 0; i < node.data.length; i++)
                {
                    var current = node.data[i];
                    current.position = getCoordinatesForNode(current, body);
                }
            }
            node.position = getCoordinatesForNode(node, body);
        });
    }

    /**
     * This adjusts the nodes in the DOM
     * to their new positions
     */
    function adjustNodeDOMPositions(nodesView, nodesData)
    {
        nodesView.children().each(function(index, child)
        {
            var el = $(child);
            var cid = el.data('node-cid');
            var node = nodesData[cid];

            el.css('top', node.position.top);
            el.css('left', node.position.left);
            el.removeClass('left right');
            // el.addClass(node.position.side);
        });
    }

    /**
     * Get the coordinates for this node
     */
    function getCoordinatesForNode(node, view)
    {
        if (node.binding === 'group')
        {
            return getCoordinatesForGroupNode(node, view);
        }

        if (node.binding === 'collection')
        {
            return getCoordinatesForCollectionNode(node, view);
        }

        return getCoordinatesForFieldNode(node, view);
    }

    /**
     * Finds the position for a collection node
     */
    function getCoordinatesForCollectionNode(node, view)
    {

        var hidden, coordinates;
        var placeholder = view.find('[data-dvs-placeholder^="' + node.key + '["]').last();
        var element = view.find('[data-devise-' + node.cid + ']').first();

        if (element.length)
        {
            hidden = !element.is(':visible');

            if (hidden) element.show();
            coordinates = element.offset();
            if (hidden) element.hide();


            if (typeof coordinates === 'object' && coordinates.top) return coordinates;
            return getCoordinatesFromParent(element);
        }

        placeholder.show();
        coordinates = placeholder.offset();
        placeholder.hide();

        if (typeof coordinates === 'object' && coordinates.top) return coordinates;
        return getCoordinatesFromParent(placeholder);
    }

    /**
     * Get the coordinates for a cid or key inside this view
     */
    function getCoordinatesForFieldNode(node, view)
    {
        var hidden, coordinates;
        var key = node.key
        var cid = node.cid
        var placeholder = view.find('[data-dvs-placeholder="' + key + '"]').last();
        var element = view.find('[data-devise-' + cid + ']').first();

        if (element.length)
        {
            hidden = !element.is(':visible');

            if (hidden) element.show();
            coordinates = element.offset();
            if (hidden) element.hide();

            if (typeof coordinates === 'object' && coordinates.top) return coordinates;
            return getCoordinatesFromParent(element);
        }

        placeholder.show();
        coordinates = placeholder.offset();
        placeholder.hide();

        if (typeof coordinates === 'object' && coordinates.top) return coordinates;
        return getCoordinatesFromParent(placeholder);
    }

    /**
     * finds the first node in the group with a position
     */
    function getCoordinatesForGroupNode(groupNode, view)
    {
        var position = false;
        var finalTop = 0;
        var finalLeft = 0;
        var nodeCountTop = 0;
        var nodeCountLeft = 0;

        $.each(groupNode.data.categories, function(index, category)
        {
            for (var i = 0; i < category.nodes.length; i++)
            {
                var node = category.nodes[i];
                var nodePosition = getCoordinatesForNode(node, view);

                // If the position isn't 0 then lets throw
                // it in the averages
                if(nodePosition.left != 0) {
                    finalLeft += nodePosition.left;
                    nodeCountLeft++;
                }
                if(nodePosition.top != 0) {
                    finalTop += nodePosition.top;
                    nodeCountTop++;
                }
            }

            // Get it in the ballpark with the last one
            position = nodePosition;

            // Average the top position of the group node
            position.top = finalTop/nodeCountTop;

            // Average the left position of the group node
            position.left = finalLeft/nodeCountLeft;

        });

        return position;
    }

    /**
     * This makes sure that no two nodes touch each other
     */
    function solveNodeCollisions(nodesView, nodesData)
    {
        var nodes = nodesData;

        var view = nodesView.closest('body');

        for (var i = 0; i < nodes.length; i++)
        {
            for (var j = 0; j < nodes.length; j++)
            {
                if (i != j && hasNodeCollision(nodes[i], nodes[j]))
                {
                    nodes[i].position.top += 55;
                    j = 0;
                    i = 0;
                }
            }
        }
    }

    /**
     * Figures out if we have a node collision
     */
    function hasNodeCollision(node1, node2)
    {
      node1.position.top = isNaN(node1.position.top) ? 0 : node1.position.top
      node1.position.left = isNaN(node1.position.left) ? 0 : node1.position.left
      node2.position.top = isNaN(node2.position.top) ? 0 : node2.position.top
      node2.position.left = isNaN(node2.position.left) ? 0 : node2.position.left

      return (
        Math.abs(node1.position.top - node2.position.top) < 55 &&
        Math.abs(node1.position.left - node2.position.left) < 200
      );
    }

    /**
     * Get the coordinates from the parent of this view,
     * sometimes stuff is nested in some deep DOM tree
     * and that stuff is hidden... so hidden elements we
     * cannot get coordinates for because it is hidden.
     * we could try unhiding it but that would give us
     * some flashy stuff on the page...
     */
    function getCoordinatesFromParent(placeholder)
    {
        var sanity = 50;
        var child = placeholder;
        var parent = placeholder.parent();
        var coordinates;

        while (child !== parent && sanity--)
        {
            coordinates = parent.offset();
            if (typeof coordinates === 'object' && coordinates.top) return coordinates;
            child = parent;
            parent = child.parent();
        }

        return { top: 0, left: 0 };
    }

    /**
     * Clean-up routine used to remove placeholder elements from DOM
     * after getting their coordinates.
     */
    function removePlaceholderElements()
    {
        $('#dvs-iframe').contents().find('[data-dvs-placeholder]').remove();
    }

    /**
     * recalculates node positions
     */
    return {
        recalculateNodePositions: function(nodesView, nodesData)
        {
            calculateNodePositions(nodesView, nodesData);
            solveNodeCollisions(nodesView, nodesData);
            adjustNodeDOMPositions(nodesView, nodesData);
            removePlaceholderElements();
        }
    };

});
