devise.define(['require', 'jquery', 'jquery-ui', 'dvsAdmin'], function (require, $) {

    var settings = {
        hoverClass: 'about-to-drop',
        ghostPreviewClass: 'ghost-dot'
    };

    var currentDotLocations = {};
    var currentDot = null;
    var currentDotType = null;
    var currentPageGroup = null;
    var currentTargetStage = null;
    var currentTargetEl = null;

    /**
     * Initializes the plugin
     */
    var initialize = function()
    {
        addDraggable();
        addDroppable();
    };

    /**
     * Add the draggable listeners to all the dots
     */
    var addDraggable = function()
    {
        $('.cq-dot').draggable({
            axis: "x",
            revert: "invalid",
            containment: "#content-queue-manager"
        });
    };

    /**
     * Adds the droppable listener to the targets and calls the appropriate functions on key events
     */
    var addDroppable = function() {
        $('.cq-target').droppable({
            over: function (event, ui) {
                mapLocations(ui.draggable);
                setEssentials(this, ui.draggable);
                previewDotMovements(this, ui.draggable);
            },
            out: function () {
                removePreview(this);
            },
            drop: function (event, ui) {
                removePreview(this);
                mapLocations(ui.draggable);


                setEssentials(this, ui.draggable);




                handleDotDrop();
            }
        });
    };

    /**
     * Builds currentDotLocations variable up so we know how far along everything is
     *
     * @param dot
     */
    var mapLocations = function (dot) {
        var pageGroup = $(dot).data('page-group');
        var pageDotsInGroup = $( '[data-page-group="' + pageGroup + '"]' );
        var lowestPoint = 6;

        currentDotLocations[pageGroup] = { pages: {} };

        pageDotsInGroup.each(function(index, dot){

            if(!$(dot).hasClass('page-dot')) {

                var stage = $(dot).parent().index();
                var fieldId = $(dot).data('field-id');
                var row = $(dot).closest('tr');

                currentDotLocations[pageGroup].pages[fieldId] = {
                    stage: stage,
                    row: row,
                    dot: dot
                };

                if (stage < lowestPoint) {
                    currentDotLocations[pageGroup].lowestPoint = stage;
                }
            }
        });
    };

    /**
     * Sets some global variables the rest of the plugin needs
     *
     * @param target
     * @param dot
     */
    var setEssentials = function(target, dot) {
        currentDot = dot;
        currentPageGroup = $(dot).data('cq-group');
        currentTargetStage = $(target).index();
        currentTargetEl = target;
        currentDotType = getCurrentDotType(dot);
    };

    /**
     * Discovers if the dot is a page or regular dot
     *
     * @param dot
     * @returns {string}
     */
    var getCurrentDotType = function(dot) {
        if(dot.hasClass('page-dot')) {
            return 'page';
        } else {
            return 'regular';
        }
    };

    /**
     * Sets the preview and hover modes as appropriate
     */
    var previewDotMovements = function() {

        if (currentDotType == 'page') {
            if (pageDotCanGoHere()) {
                addPreview();
                addHover();
            }
        } else {
            addHover();
        }
    };

    /**
     * Checks to see if the page dot stage is not less than at least one of the regular dot stages
     *
     * @returns {boolean}
     */
    var pageDotCanGoHere = function() {
        var returnValue = false;

        $.each(currentDotLocations[currentPageGroup].pages, function(index, data) {
            if (data.stage <= currentTargetStage) {
                returnValue = true;
            }
        });

        return returnValue;
    };

    /**
     * Adds the preview dots when hovering with the page dot
     */
    var addPreview = function() {

        $.each(currentDotLocations[currentPageGroup].pages, function(index, data) {

            var ghostDot = $('<div>').addClass(settings.ghostPreviewClass).html('&nbsp;');

            if (data.stage < currentTargetStage) {
                $(data.row).children('td').eq(currentTargetStage).html(ghostDot);
            }
        });
    };

    /**
     * Adds the hover style to the current target
     */
    var addHover = function () {
        $(currentTargetEl).addClass(settings.hoverClass);
    };


    var removePreview = function(hoveringOn) {
        $(hoveringOn).removeClass(settings.hoverClass);
        $('.' + settings.ghostPreviewClass).remove();
    };

    /**
     * Splits tasks based on the current dot type and executes the appropriate functions
     */
    var handleDotDrop = function() {
        if (currentDotType == 'page') {
            if (pageDotCanGoHere()) {
                moveDot(currentDot, currentTargetEl);
                moveChildrenDots();
            } else {
                revertCurrentDot();
            }
        } else {

            moveDot(currentDot, currentTargetEl);
            movePageDot();
        }
    };

    /**
     * Moves a dot to a given target
     *
     * @param dot
     * @param target
     */
    var moveDot = function(dot, target) {
        var newDot = $(dot).clone();
        newDot.css({
            left: 'auto',
            top: 'auto'
        });

        $(target).html(newDot);
        $(dot).remove();

        addDraggable();
    };

    /**
     * Reverts a draggable dot back to it's original location
     */
    var revertCurrentDot = function() {
        currentDot.draggable('option','revert',true);
    }


    /**
     * Moves children dots up to the point of the pageDot
     */
    var moveChildrenDots = function() {
        $.each(currentDotLocations[currentPageGroup].pages, function(index, data) {
            if (data.stage < currentTargetStage) {
                var newTarget = $(data.dot).closest('tr').children('td').eq(currentTargetStage);
                moveDot(data.dot, newTarget);
            }
        });
    };

    /**
     * Moves the page dot back if needed
     */
    movePageDot = function() {

        var lowestPoint = currentDotLocations;
        var currentPageDot = $('#cq-page-dot-' + currentPageGroup);
        var currentPageDotStage = currentPageDot.parent().index();
        if (lowestPoint < currentPageDotStage) {

        }
    };

    initialize();
});
