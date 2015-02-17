@extends('devise::layouts.admin')

@section('devise-main')
    <div id="dvs-mode" class="dvs-default">
        <div id="dvs-container">
            <div id="dvs-sidebar">
                <div id="dvs-sidebar-header">
                    <div class="dvs-sidebar-title">Edit Group</div>

                    <div class="dvs-sidebar-controls">
                        <div id="dvs-admin-gear">&nbsp;</div>
                        <div id="dvs-sidebar-close">&nbsp;</div>
                    </div>
                </div>

                <div id="dvs-admin-menu">
                    <li>Item One</li>
                    <li>Item Two</li>
                    <li>Item Three</li>
                    <li>Item Four</li>
                    <li>Item Five</li>
                    <li>Item Six</li>
                </div>

                <ul class="dvs-edit-element">
                    <li>
                        <select name="Whatever" class="fancyselect">
                            <option>English</option>
                            <option>German</option>
                            <option>Japanese</option>
                        </select>
                    </li>
                </ul>

                <div class='dvs-group-edit'>
                    <h3>Background Image</h3>
                    <div>
                        <div class="dvs-preview-media">
                            <ul class="dvs-preview-media-controls">
                                <li><a class="dvs-media-controls-zoom"></a></li>
                                <li><a class="dvs-media-controls-remove"></a></li>
                                <li><a class="dvs-media-controls-upload"></a></li>
                                <li><a class="dvs-media-controls-gallery"></a></li>
                            </ul>
                            <img src="<?= URL::asset('img/FOP/placeholder-image.png') ?>" width="320" height="225">
                        </div>

                        <ul class="dvs-edit-element">
                            <li>
                                <select name="Whatever" class="fancyselect">
                                    <option>Select from a past version</option>
                                    <option>#113: December 5th, 2013 @ 1:15pm</option>
                                    <option>#112: December 3rd, 2013 @ 11:15am</option>
                                    <option>#111: December 3rd, 2013 @ 9:15am</option>
                                </select>
                            </li>
                        </ul>
                        <ul class="dvs-edit-element">
                            <li>
                                <div class="dvs-input-wrapper">
                                    <input type="text" name="alt" placeholder="Alternative Text">
                                </div>
                            </li>
                        </ul>
                        <ul class="dvs-edit-element">
                            <li>
                                <label form="status">Status</label>
                                <select name="status" class="fancyselect">
                                    <option>Not Yet Approved</option>
                                    <option>Approved</option>
                                </select>
                            </li>
                            <li>
                                <label form="publishes">Publishes</label>
                                <div class="dvs-input-wrapper">
                                    <input type="text" class="dvs-datepicker dvs-datepicker-skin" name="publishes">
                                    <span class="dvs-date-icon"></span>
                                </div>
                            </li>
                        </ul>
                        <ul class="dvs-actions-wrapper">
                            <li><input type="reset" value="Cancel"></li>
                            <li><input type="submit" value="Save"></li>
                        </ul>
                    </div>
                    <h3>Primary Title</h3>
                    <div>
                        Editor stuff
                    </div>
                </div>
            </div>

	        <div>Admin</div>
	        <div>Sidebar</div>

            <div id="dvs-pusher">
                <div id="dvs-content">

	                @yeild('main')

                    <div id="dvs-edit-nodes"></div>
                    <div id="dvs-content-edit-shadow"></div>
                </div>

            </div>

            <div id="dvs-blocker">&nbsp;</div>

        </div>


        <button id="dvs-edit-mode-button">Edit</button>
    </div>


@stop

@section('scripts')
    <script type="text/javascript">
        $(function() {
            var editNodes = new Array();
            var editNodeWidth = 50;
            var editNodeHeight = 50;
            var editNodeThreshold = 10;
            var editNodesCalculated = false;

            calculateDvsContainerHeight();

            // Removes class disabling animation on page load
            $("body").removeClass("preload");

            // fires anytime window is resized so node position
            // can be reset to eliminate incorrect coordinate(s)
            $(window).resize(function() {
                editNodes = new Array();
                editNodesCalculated = false;
                calculateDvsContainerHeight();

                // removes any previously rendered nodes from DOM
                $('#dvs-edit-nodes .dvs-edit-node').remove();

                closeAdmin();
            });

            $('#dvs-edit-mode-button').click(function() {

                if(!$('#dvs-mode').hasClass('dvs-edit-mode')) {
                    openEditPage();
                } else {
                    closeAdmin();
                }
            });

            $('#dvs-edit-nodes').on('click', '.dvs-edit-node', function() {
                openSidebar();
            });

            $("#dvs-blocker").click(function() {
                openEditPage();
            });



            /*****************************/
            /*       Main Animation
            /*          Functions
            /*****************************/

            function openEditPage()
            {
                // only calculate coordinates once
                if(editNodesCalculated === false) {
                    placeEditNodes();
                    editNodesCalculated = true;
                } else {
                    executeOpenEditPage();
                }
            }

            function executeOpenEditPage()
            {
                $('#dvs-mode')
                    .removeClass('dvs-admin-mode dvs-sidebar-mode')
                    .addClass('dvs-edit-mode');
                $('#dvs-edit-mode-button').html('Exit Editor');
            }

            function closeAdmin()
            {
                $('#dvs-mode').removeClass('dvs-edit-mode dvs-admin-mode dvs-sidebar-mode');
            }

            function openSidebar()
            {
                $('#dvs-mode')
                    .removeClass('dvs-edit-mode dvs-admin-mode')
                    .addClass('dvs-sidebar-mode');
            }


            /*****************************/
            /*     Editor Node Support
            /*          Functions
            /*****************************/

            /**
             * Uses calculated coordinates to dynamically place edit nodes
             *
             * @return Void
             */
            function placeEditNodes()
            {
                $('.dvs-editor').each(function() {
                    var coordinates = $(this).offset();
                    coordinates = editNodeCollisions(coordinates);

                    // store coordinates on initial opening of "Edit Mode"
                    if(editNodesCalculated === 0) {
                        storeInitialCoordinates($(this), coordinates);
                    }

                    var newNode = $('<div>')
                        .addClass('dvs-edit-node')
                        .css({
                            top : coordinates.top,
                            left : coordinates.left
                        });

                    $('#dvs-edit-nodes').append(newNode);
                });

                executeOpenEditPage();
            }

            /**
             * Store the initially-calculated coordinates of each edit node
             *
             * @return Void
             */
            function storeInitialCoordinates($this, coordinates)
            {
                $this.data("initialOffsetTop", coordinates.top);
                $this.data("initialOffsetLeft", coordinates.left);
            }

            /**
             * Finds where collisions are occuring and shifts them
             *
             * @return Void
             */
            function editNodeCollisions(coordinates)
            {
                editNodes.forEach(function(node) {
                    var x2 = node.left + editNodeWidth;
                    var y2 = node.top + editNodeHeight;

                    if((coordinates.left >= node.left && coordinates.left <= x2)
                        && (coordinates.top >= node.top && coordinates.top <= y2)) {
                        coordinates.top+=5;
                        coordinates.left+=5;

                        coordinates = editNodeCollisions(coordinates);
                    }
                });

                editNodes.push(coordinates);

                return coordinates;
            }


            /*****************************/
            /*       General Support
            /*          Functions
            /*****************************/

            /**
             * Calculates height of the container
             *
             * @return Void
             */
            function calculateDvsContainerHeight()
            {
                $('#dvs-container').css('height', $(window).height());
            }

            /*****************************/
            /*          Editor
            /*         Functions
            /*****************************/

            // Initialize fancySelect
            $('.fancyselect').fancySelect();

            // Initialize accordions on group editors
            $( ".dvs-group-edit" ).accordion({
                collapsible: false,
                autoHeight: false
            });

            $( ".dvs-datepicker" ).datepicker({
                showAnim: "fade",
                beforeShow: function(input, inst) {
                    if ($(input).hasClass('dvs-datepicker-skin')) {
                        $('#ui-datepicker-div').addClass('dvs-datepicker-skin');
                    }
                }
            });
        });
    </script>
@stop
