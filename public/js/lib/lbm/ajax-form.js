devise.define(["jquery", "requests"], function ( $ ) {
	// Setting of defaults
	var pluginName = "ajaxForm",
		defaults = {
            messagesSelector:   '#validation-messages',
            successTargetSelector:   null,
            successTargetFunction:   "prepend",
            onEvent: 'submit',
            wizardMode: false,
            defaultSelector: '.ajax-form'
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
            // Process form submit
            base.processFormSubmit();
        },

        /**
         * Listens for submit from any form with class ".ajax-form". It also
         * serializes all form data and submits to request plugin
         *
         * @return {void}
         */
        processFormSubmit: function()
        {
            var base = this;

            if($(this.element).hasClass('wizard')){
                this.setWizardMode(true);
            }

            if($(this.element).hasClass('onchange')){
                this.setOnEvent('change');
            }

            // submit event for the current form
            $(this.element).on(this.settings.onEvent, function(event) {
                event.preventDefault();

                // Submit serialized POST data to Requests
                base._sendDataToRequestsPlugin(
                    $(this).attr('method'),
                    $(this).attr('action'),
                    $(this).serialize()
                );
            });
        },

        /**
         * Set messagesSelector value
         * @return {void}
         */
        setMessagesSelector: function(selector)
        {
            this.settings.messagesSelector = selector;
        },

        /**
         * Set successTargetSelector value
         * @return {void}
         */
        setSuccessTargetSelector: function(selector)
        {
            this.settings.successTargetSelector = selector;
        },

        /**
         * Set successTargetFunction value
         * @return {void}
         */
        setSuccessTargetFunction: function(functionName)
        {
            this.settings.successTargetFunction = functionName;
        },

        /**
         * Set onEvent value
         * @return {void}
         */
        setOnEvent: function(eventName)
        {
            this.settings.onEvent = eventName;
        },

        /**
         * Set wizardMode value
         * @return {void}
         */
        setWizardMode: function(wizardMode)
        {
            this.settings.wizardMode = wizardMode;
        },

        /**
         * Initializes requests plugin and then set defaults
         * @return {void}
         */
        _sendDataToRequestsPlugin: function(method, action, data)
        {
            var base = this;

            // init. Requests Plugin
            $(this.element).requests();

            // set options/settings with form data
            $(this.element).requests('setOptions', method, action, data);

            // execute getAjax function
            $(this.element).requests('getAjax');

            // properly handle request response
            base._handleReponse();
        },

        /**
         * Handle response for request
         * @return {void}
         */
        _handleReponse: function()
        {
            var base = this;

            // listen for "postRequestsDone"
            $(this.element).one('postRequestsDone', function(response){
                if(base.settings.wizardMode){
                    base._loadNextStep(response.msg);
                } else {
                    base._showResponseMessage(response, 'success');
                }
            });

            // check for "getRequestsDone"
            $(this.element).one('getRequestsDone', function(response){ });

            // check for "requestsFail"
            $(this.element).one('requestsFail', function(response){
                base._showResponseMessage(response, 'danger');
            });

            // check for "requestsAlways"
            $(this.element).one('requestsAlways', function(response){ });
        },

        /**
         * Build message html
         * @param {string} html
         * @return voie
         */
        _loadNextStep: function(html)
        {
            $(this.element).replaceWith(html);
            if($(this.settings.defaultSelector).length > 0){
                $(this.settings.defaultSelector).ajaxForm();
            }

            $(document).trigger('wizardStep.loaded', [this.element]);
        },

        /**
         * Build message html
         * @param {object} responseObj
         * @return {string}
         */
        _showResponseMessage: function(response, type)
        {
            var base = this;
            var responseObj = null;
            try {
                responseObj = $.parseJSON(response.msg);
            } catch (e) {}
            
            if(responseObj){
                if(responseObj.hasOwnProperty('message')){
                    var message = base._buildHtmlMessage(responseObj);

                    // insert response into "#validation-messages" div
                    $(base.settings.messagesSelector).addClass('alert alert-' + type).html(message);
                    var t = setTimeout(function(){
                        $(base.settings.messagesSelector).removeClass('alert alert-' + type).html(null);
                        clearTimeout(t);
                    }, 3000);
                }

                if(type == 'success') {
                    base._injectResponseHtml(responseObj);
                }
            }
        },

        /**
         * Build message html
         * @param {object} responseObj
         * @return {string}
         */
        _buildHtmlMessage: function(responseObj)
        {
            var message = '<h3 class="mz">'+responseObj.message+'</h3>';

            if(responseObj.data.errors) {
                message += '<ul>';
                for(var i = 0; i < responseObj.data.errors.length; i++) {
                    message += '<li>'+responseObj.data.errors[i]+'</li>';
                }
                message += '</ul>';
            }

            return message;
        },

        /**
         * Insert response html
         * @param {object} responseObj
         * @return {void}
         */
        _injectResponseHtml: function(responseObj)
        {
            if(this.settings.successTargetSelector !== null && responseObj.data.html.length) {
                $(this.settings.successTargetSelector)[this.settings.successTargetFunction](responseObj.data.html);
            }
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