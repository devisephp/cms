define(["jquery"], function ( $ ) {
	// Setting of defaults
	var pluginName = "filterList",
		defaults = {
            characters:   3,
            targetList:   null
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
            if (this.settings.targetList != null) {
                $(this.element).keyup(function () {
                    base._performFilter($(this).val());
                });
            }
        },

        _performFilter: function(search)
        {
            $(this.settings.targetList).children().each(function() {
                if ($(this).text().search(search) > -1) {
                    $(this).show();
                }
                else {
                    $(this).hide();
                }
            });
        }

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