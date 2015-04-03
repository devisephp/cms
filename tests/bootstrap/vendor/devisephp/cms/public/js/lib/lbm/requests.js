devise.define(["jquery"], function ( $, window, document, undefined ) {
	// Setting of defaults
	var pluginName = "requests",
		defaults = {
			debug:              "false",
            method:             "GET",
            url:                "",
            success:            true,
            data:               null,
			dataType:           "html",
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
		init: function() { },

        /**
         * Sets method, action and data properties
         * @param {string} method
         * @param {string} url
         * @param {string} data
         * @return {void}
         */
        setOptions: function(method, url, data)
        {
            this.setMethod(method);
            this.setUrl(url);
            this.setData(data);
        },

        /**
         * Set method settings value
         * @param {string} method
         * @return {void}
         */
        setMethod: function(method)
        {
            this.settings.method = method;
        },

        /**
         * Set url settings value
         * @param {string} url
         * @return {void}
         */
        setUrl: function(url)
        {
            this.settings.url = url;
        },

        /**
         * Set success settings value
         * @param {string} success
         * @return {void}
         */
        setSuccess: function(success)
        {
            this.settings.success = success;
        },

        /**
         * Set data settings value
         * @param {string} data
         * @return {void}
         */
        setData: function(data)
        {
            this.settings.data = data;
        },

        /**
         * Set dataType settings value
         * @param {string} dataType
         * @return {void}
         */
        setDataType: function(dataType)
        {
            this.settings.dataType = dataType;
        },

        /**
         * Executes ajax request
         * @return {void}
         */
        getAjax: function()
        {
            var base = this;

            $.ajax({
                url: base.settings.url,
                type: base.settings.method,
                data: base.settings.data,
                dataType: base.settings.dataType,
            }).done(function(msg) {
                base._done(msg);
            }).fail(function(msg) {
                base._fail(msg);
            }).always(function(msg) {
                base._always(msg);
            });
        },

        /**
         * Handles "done" msg for ajax requests
         * @param {string} msg
         * @return {void}
         */
        _done: function (msg)
        {
            // handle form method types in differently
            if(this.settings.method === 'POST') {
                this._setResponse('postRequestsDone', msg);
            } else {
                this._setResponse('getRequestsDone', msg);
            }
        },

        /**
         * Handles "fail" msg for ajax requests
         * @param {string} msg
         * @return {void}
         */
        _fail: function (msg)
        {
            // set success settings value to false
            this.setSuccess(false);
            this._setResponse('requestsFail', msg.responseText);
        },

        /**
         * Handles "always/complete" msg for ajax requests
         * @return {void}
         */
        _always: function (msg)
        {
            this._setResponse('requestsAlways', msg);
        },

        /**
         * Execute trigger method on current element
         *
         * @param {string} type
         * @param {object} msg
         * @return {void}
         */
        _setResponse: function (type, msg)
        {
            $(this.element).trigger({
                'type': type,
                'success': this.settings.success,
                'msg': msg,
                'method': this.settings.method,
                'url': this.settings.url,
                'data': this.settings.data
            });
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