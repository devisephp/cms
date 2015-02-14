
devise.define(['require', 'jquery', 'dvsPageData'], function (require, $, dvsPageData) {

    var nodes = null;
    var nodeHeight = 82;
    var nodeThreshold = 5;
    var nodesCalculated = false;
    var contentRequestedKeysArr = [];

    var initializeNodeView = function () {
        nodes = [];
        devise.nodes = nodes;
        checkContentRequested(function(){
            loadNodeLocations();
            solveNodeCollisions();
            placeNodes();
            openNodeMode();
        });

        return true;
    };

    function checkContentRequested(callback) {
        $.ajax({
            type: 'get',
            url: dvsPageData.content_requested_url,
            cache: false
        }).done(function(fieldKeysArr) {
            // set global var "contentRequestedKeysArr"
            // equal to array of keys returned
            contentRequestedKeysArr = fieldKeysArr;

            isKeyInContentRequestedArr(dvsPageData.bindings);

            callback();
        });
    }

    /**
     * Checks each _binding.key against contentRequestedKeysArr
     * to determine if the should be marked
     *
     * @param  {object} _binding
     * @return {boolean}
     */
    function isContentRequestedInBinding(_binding) {
        // if the binding.key value is in array, add
        // the "contentRequested" property to binding object
        if($.inArray(_binding.key, contentRequestedKeysArr) != -1){
            return true;
        }

        return false;
    }

    function isKeyInContentRequestedArr(_data) {
        // loop thru bindings and sets property "contentRequested"
        // on current data set
        $.each(_data, function(index, binding) {
            binding.contentRequested = isContentRequestedInBinding(binding);
        });
    }

    function loadNodeLocations() {
        // Collections
        $.each(dvsPageData.collections, function(collectionName, collection) {

            $.each(collection, function(index, binding) {

                binding.contentRequested = isContentRequestedInBinding(binding);

                // build to binding with flag to turn on collection true
                buildBinding(index, binding, collectionName);
            });
        });

        // Regular groups and other nodes
        $.each(dvsPageData.bindings, buildBinding);
        $.each(dvsPageData.models, buildModelNode);
        $.each(dvsPageData.model_attributes, buildModelAttributeNode);
        $.each(dvsPageData.model_creators, buildModelCreatorNode);
    }

    function buildModelNode(index, model)
    {
        var props = {};

        // the sidebar is going to treat this like a model type
        model.type = 'model';

        // Start the coordinates where the item is located
        props.type = 'model';
        props.element = model;
        props.element.index = index;
        props.coordinates = getCoordinatesFromCid(model.cid);
        props.collection = model.collection;
        props.categoryName = null;
        props.group = model.collection;

        var inCategory = isInCategory(props);
        var inGroup = isInGroup(props);
        var groupNode = getGroupNode(props);
        var categoryNode = getIndexOfCategoryNode(inCategory, props);

        addToNodesArray(inGroup, categoryNode, groupNode, props);
    }

    function buildModelAttributeNode(index, modelAttribute)
    {
        var props = {};

        modelAttribute.type = 'attribute';
        props.type = 'attribute';
        props.element = modelAttribute;
        props.element.index = index;
        props.coordinates = getCoordinatesFromCid(modelAttribute.cid);
        props.collection = modelAttribute.collection;
        props.categoryName = null;
        props.group = modelAttribute.collection;

        var inCategory = isInCategory(props);
        var inGroup = isInGroup(props);
        var groupNode = getGroupNode(props);
        var categoryNode = getIndexOfCategoryNode(inCategory, props);

        addToNodesArray(inGroup, categoryNode, groupNode, props);
    }

    function buildModelCreatorNode(index, modelCreator)
    {
        var props = {};

        // the sidebar is going to treat this like a model creator type
        modelCreator.type = 'model_creator';
        modelCreator.humanName = modelCreator.human_name;

        // Start the coordinates where the item is located
        props.type = 'model_creator';
        props.element = modelCreator;
        props.element.index = index;
        props.coordinates = getCoordinatesFromCid(modelCreator.cid);
        props.collection = null;
        props.categoryName = null;
        props.group = null;

        var inCategory = isInCategory(props);
        var inGroup = isInGroup(props);
        var groupNode = getGroupNode(props);
        var categoryNode = getIndexOfCategoryNode(inCategory, props);

        addToNodesArray(inGroup, categoryNode, groupNode, props);
    }

    function buildBinding(index, binding, collectionName) {
        var props = {};

        props.coordinates = null;
        props.contentRequested = '';

        if (typeof collectionName == 'undefined') {
            collectionName = '';
        }

        // Start the coordinates where the item is located
        props.element = binding;
        props.element.index = index;
        props.element.alternateTarget = binding.alternateTarget;
        props.coordinates = getCoordinates(binding, index, collectionName);
        props.categoryName = binding.category;
        props.group = binding.group;
        props.collection = collectionName;

        var inCategory = isInCategory(props);
        var inGroup = isInGroup(props);
        var groupNode = getGroupNode(props);
        var categoryNode = getIndexOfCategoryNode(inCategory, props);

        addToNodesArray(inGroup, categoryNode, groupNode, props);
    }

    function getCoordinates(binding, index, collectionName) {
        var collection = collectionName ? collectionName + '-' : '';
        var selector = '[data-dvs-' + collection + binding.key + '-id="' + binding.key + '"]';
        var coords = $(selector).first().offset();

        // attempt to find the hidden placeholder for
        // this binding/collection since we do not see
        // it on the page. This could be a devise-tag
        // inside of @if or @foreach blocks
        if (typeof coords === 'undefined') {
            selector = '[data-dvs-placeholder-' + collection + binding.key + '-id="' + binding.key + '"]';
            $(selector).first().show();
            coords = $(selector).first().offset();
            $(selector).first().hide();
        }

        return coords;
    }

    function getCoordinatesFromCid(cid)
    {
        var selector = '[data-dvs-cid-' + cid + ']';
        var coords = $(selector).first().offset();

        if (typeof coords === 'undefined')
        {
            $(selector).first().show();
            coords = $(selector).first().offset();
            $(selector).first().hide();
        }

        return coords;
    }

    function isInCategory(props) {
        return props.categoryName !== null;
    }

    function isInGroup(props) {
        return props.group !== null;
    }

    function getIndexOfCategoryNode(inCategory, props) {
        var _categoryNode = false;

        if (inCategory) {
            _categoryNode = getCategoryNode(props);

            if (_categoryNode === false) {
                // Node for this category hasn't been made yet - let's make it!
                _categoryNode = makeCategoryNode(props);
            }
        }
        return _categoryNode;
    }

    function getCategoryNode(props) {
        var _categoryExists = false;

        $.each(nodes, function (index, node) {
            if (node.categoryName == props.categoryName) {
                _categoryExists = index;
            }
        });

        return _categoryExists;
    }

    function addToNodesArray(inGroup, categoryNode, groupNode, props) {

        if (inGroup) {
            if (categoryNode !== false && groupNode !== false) {
                // Category Node and group index exists
                addToGroup(groupNode, props);
            } else if (categoryNode !== false && groupNode === false) {
                // Category Node exists but not the group index
                makeGroupInCategory(categoryNode, props);
                addToCategoryCount(categoryNode);
            } else if (groupNode !== false){
                // Group index exists
                addToGroup(groupNode, props);

            } else {
                // Node for this group doesn't exist
                makeGroupNode(props);
            }
        } else {
            // Add to elements
            makeSimpleElementNode(props);
        }

    }

    function getGroupNode(props) {

        var _groupExists = false;

        $.each(nodes, function (index, node) {

            if (typeof node.groups != 'undefined') {

                $.each(node.groups, function (groupName) {

                    if (groupName == props.group) {
                        _groupExists = index;
                    }
                });
            }
        });

        return _groupExists;
    }

    function makeCategoryNode(props) {
        return nodes.push({
            coordinates: props.coordinates,
            collection: props.collection,
            categoryName: props.categoryName,
            type: props.type,
            contentRequested: props.contentRequested,
            categoryCount: 0
        }) - 1;
    }

    function makeGroupInCategory(index, props) {
        if (typeof nodes[index].groups == 'undefined') {
            nodes[index].groups = {};
        }

        nodes[index].groups[props.group] = [];
        nodes[index].groups[props.group].push(props.element);
    }

    function addToCategoryCount(index) {
        nodes[index].categoryCount++;
    }

    function addToGroup(groupNode, props) {
        // check and set contentRequested prop
        if(typeof props.element.contentRequested != 'undefined' &&
            props.element.contentRequested === true)
        {
            nodes[groupNode].contentRequested = ' dvs-content-requested';
        }

        nodes[groupNode].groups[props.group].push(props.element);
    }

    function makeGroupNode(props) {
        var _index = nodes.push({
                coordinates: props.coordinates,
                collection: props.collection,
                type: props.type,
                contentRequested: props.contentRequested,
                groups: {}
        }) - 1;

        nodes[_index].groups[props.group] = [];
        nodes[_index].groups[props.group].push(props.element);
    }

    function makeSimpleElementNode(props) {
        var _index = nodes.push({
                coordinates: props.coordinates,
                collection: props.collection,
                type: props.type,
                contentRequested: props.contentRequested,
                elements: []
        }) - 1;

        nodes[_index].elements.push(props.element);
    }

    /**
     * Uses calculated coordinates to dynamically place edit nodes
     *
     * @return Void
     */
    function placeNodes() {
        $.each(nodes, function (index, node) {
            placeNode(node);
        });
    }

    function calculateSide(coordinates) {
        var half = $(window).width() / 2;
        var side = 'left';

        if (typeof coordinates == 'undefined') {
            side = 'float';
        } else if (coordinates.left > half) {
            side = 'right';
        }

        return side;
    }

    function placeNode(node) {
        var side = calculateSide(node.coordinates);
        var contentRequested = typeof node.contentRequested === 'undefined' ? '' : node.contentRequested;

        var newNode = $('<div>')
            .addClass('dvs-node ' + side + ' ' + contentRequested)
            .css({
                top: node.coordinates.top
            });

        var label = getLabel(node);

        var newNodeInnerWrapper = $('<div>').addClass('dvs-node-inner-wrapper');
        var labelTag = $('<span>').html(label);
        var svgPath = require.toUrl('/packages/devisephp/cms/img/node-arrow.svg');
        var svg = $(newNodeInnerWrapper).load(svgPath);

        newNode.append(newNodeInnerWrapper);
        newNode.append(labelTag);
        newNode.data('dvsData', node);

        $('#dvs-nodes').append(newNode);
    }

    function getLabel(node) {
        if (typeof node.categoryName != 'undefined') {
            return node.categoryName + ' <span class="count">' + node.categoryCount + '</span>';
        } else if (typeof node.groups != 'undefined') {
            // There can only be one group so let's grab the first index key
            return Object.keys(node.groups)[0];
        } else {
            // There can only be one element so let's grab the first one's human name
            return node.elements[0].humanName;
        }
    }

    /**
     * Finds where collisions are occurring and shifts them
     *
     * @return Void
     */
    function solveNodeCollisions() {

        // Flip it so we work from the bottom of the DOM up
        nodes.reverse();

        // Loop through each node and discover any collisions
        $.each(nodes, function (index, node) {

            var nodeSide = calculateSide(node.coordinates);

            if (nodeSide !== 'float' && solveCollision(node, nodeSide, index) > 0) {
                nodes.reverse();
                solveNodeCollisions();
            }

        });

        // Flip it back!
        nodes.reverse();
    }

    function solveCollision(node, nodeSide, index) {
        var collisions = 0;

        $.each(nodes, function (i, comparisonNode) {
            // Ignore comparison with itself
            if (i != index) {

                // Calculate if they are on the same side
                var comparisonSide = calculateSide(comparisonNode.coordinates);
                var comparisonNodeY2 = comparisonSide == 'float' ? 'float' : comparisonNode.coordinates.top + nodeHeight;

                // If they are on the same side and collide vertically we have a collision
                while (
                        // Are they on the same side?
                        (comparisonSide == nodeSide) &&
                        // Is the current node's top coordinate between the comparison node's top and bottom?
                        (node.coordinates.top >= comparisonNode.coordinates.top &&
                        node.coordinates.top <= comparisonNodeY2)
                    ) {
                    // We have a collision so push it down a little
                    nodes[index].coordinates.top += nodeThreshold;
                    collisions++;
                }
            }
        });

        return collisions;
    }

    function openNodeMode() {
        $('#dvs-mode')
            .removeClass('dvs-admin-mode dvs-sidebar-mode')
            .addClass('dvs-node-mode');
        $('#dvs-node-mode-button').html('Exit Editor');
    }

    return initializeNodeView;

});
