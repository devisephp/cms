define(["jquery", "requests"], function ( $ ) {
    // Setting of defaults
    var pluginName = "modal",
        defaults = {
            template:           null,
            method:             "GET",
            beforeLaunch:       null,
            afterLaunch:        null,
            beforeClose:        null,
            afterClose:         null,
            type:               'fat',
            fireMultiple:       true,
            fixed:              true
        };

    // The actual plugin constructor
    function Plugin ( element, options ) {
        this.element = element;
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        /**
         * Initializes the Plugin
         * @return {void}
         */
        init: function ()
        {
            var base = this;

            // get modal type, 'fat' or 'skinny'
            this._getType();

            // add Click Event Listener to open modal
            this._addClickEvent();

            // add Initial request listener to open modal
            this._addRequestEvents();
        },

        /**
         * Handles the appending and showing of modal
         * @return {void}
         */
        launchModal: function ()
        {
            // remove any previous modal and blocker elements
            $('#modal-wrapper').remove();
            $('#bg-blocker').remove();

            // init requests plugin, set url value and execute getAjax
            $(this.element).requests();
            $(this.element).requests('setUrl', this.settings.template);
            $(this.element).requests('getAjax');
        },

        /**
         * Handles hiding and removing of modal, blocker and spinner elements
         * @return {void}
         */
        closeAndRemove: function ()
        {
            var base = this;

            // callback for "beforeClose"
            if(base.settings.beforeClose != undefined && typeof base.settings.beforeClose == 'function'){
                base.settings.beforeClose();
            }

            $('#modal-wrapper').addClass('fadeout');
            $('#bg-blocker').addClass('fadeout');

            // ensure animation/transition is complete before removing elements
            $('#modal-wrapper').on('webkitAnimationEnd oanimationend msAnimationEnd animationend webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
                $('#modal-wrapper').remove();
                $('#bg-blocker').remove();
            });

            // callback for "afterClose"
            if(base.settings.afterClose != undefined && typeof base.settings.afterClose == 'function'){
                base.settings.afterClose();
            }

            if(base.settings.fireMultiple) {
                // execute addClickEvent to re-enable ".one" event handler
                // for the each element with the ".ajax-modal" class
                this._addClickEvent();

                // re-add the requests events
                this._addRequestEvents();
            }
        },

        /**
         * Adds click event listener for elements with "modal-trigger" class
         * @return {void}
         */
        _addClickEvent: function()
        {
            var base = this;

            $(this.element).one('click', function(event) {
                event.preventDefault();
                var launchModal = true;
                // dynamically retrieve url for element using the type
                base.settings.template = base._getUrlBasedOnElementType(event.currentTarget);

                // callback for "beforeLaunch"
                if(base.settings.beforeLaunch != undefined && typeof base.settings.beforeLaunch == 'function'){
                    launchModal = base.settings.beforeLaunch();
                }

                if(launchModal){
                    // launch modal window
                    base.launchModal();
                } else {
                    base._addClickEvent();
                }
            });
        },

        _addRequestEvents: function()
        {
            var base = this;

            // listening for "getRequestsDone" event
            $(this.element).one('getRequestsDone', function(response){
                base._loadContents(response.msg);
            });

            // listening for "requestsFail" event
            $(this.element).one('requestsFail', function(response){
                alert('Unable to load requested url: '+response.url);
            });
        },

        /**
         * Gets the url to be loaded based on type of DOM element
         * @param {element}
         * @return {string}
         */
        _getUrlBasedOnElementType: function(element)
        {
            // gets element type using localName property and grabs url accordingly
            if(element.localName != 'a') {
                return element.getAttribute('data-url');
            }

            return element.getAttribute('href');
        },

        /**
         * Loads contents of modal
         * @return {void}
         */
        _loadContents: function(contents)
        {
            var base = this;

            var modalWrapper = $("<div>", {id: "modal-wrapper", class: "visible loading"}).addClass(this.settings.type);
            var spinner = $("<div>", {id: "spinner"});
            var blocker = $("<div>", {id: "bg-blocker", class: "visible"});

            // Add close event handlers to modal-wrapper and blocker
            base._addCloseEventHandlers(modalWrapper, blocker);

            // add them to the DOM
            modalWrapper.append(spinner).appendTo('body');
            blocker.appendTo('body');

            // prepend response html before markup for #spinner div
            $('#modal-wrapper').prepend(contents);

            // Retrieve necessary size and position of modal
            this._getSizeAndPosition();

            // check if modal transition and/or animation is complete, if so remove
            // ".loading" class and replace it with ".loaded" class
            $("#modal-wrapper").on('webkitAnimationEnd oanimationend msAnimationEnd animationend webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
                $(this).removeClass('loading').addClass('loaded');
            });

            // callback for "afterLaunch"
            if(base.settings.afterLaunch != undefined && typeof base.settings.afterLaunch == 'function'){
                base.settings.afterLaunch();
            }
        },

        /**
         * Get "data-modal-type" attribute
         * @return {void}
         */
        _getType: function()
        {
            var type = $(this.element).attr('data-modal-type');
            if (type !== undefined) {
                this.settings.type = type;
            }
        },

        /**
         * Add modal-wrapper click event for any element with ".modal-close" or blocker
         * @return {void}
         */
        _addCloseEventHandlers: function(modalWrapper, blocker)
        {
            var base = this;

            $(modalWrapper).on('click', '.modal-close', function(){
                base.closeAndRemove();
            });

            $(blocker).click(function(){
                base.closeAndRemove();
            });
        },

        /**
         * Determine if modal height exceeds the viewport height. If true,
         * then scroll to top and if not then change position to fixed
         * @return {void}
         */
        _getSizeAndPosition: function()
        {
            if(this._compareHeights($('#modal-wrapper').height()) !== false) {
                $("body").one().animate({ scrollTop: 75 }, "fast");
            } else {
                if(this.settings.fixed) {
                    $('#modal-wrapper').one().css('position', 'fixed');
                }
            }
        },

        /**
         * Compare height of modal (with contents loaded) against viewport height.
         * @param {integer} elementHeight
         * @return {boolean}
         */
        _compareHeights: function(elementHeight)
        {
            return elementHeight > $(window).height();
        },
    };

    $.fn[pluginName] = function ( options ) {
        var args = arguments;

        if (options === undefined || typeof options === 'object') {
            return this.each(function ()
            {
                if (!$.data(this, 'plugin_' + pluginName))
                {
                    $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
                }
            });
        }
        else if (typeof options === 'string' && options[0] !== '_' && options !== 'init')
        {
            var returns;

            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);

                if (instance instanceof Plugin && typeof instance[options] === 'function')
                {
                    returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
                }

                if (options === 'destroy')
                {
                    $.data(this, 'plugin_' + pluginName, null);
                }
            });

            return returns !== undefined ? returns : this;
        }
    };

});