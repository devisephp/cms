devise.define(["jquery", "typeahead"], function ( $ ) {
	// Setting of defaults
	var pluginName = "autoComplete",
		defaults = {};

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

            var url = $(this.element).attr('data-url');
            var engine = new Bloodhound({
                datumTokenizer: function(d) {
                    return Bloodhound.tokenizers.whitespace(d.val);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: url + '?query=%QUERY',
                }
            });

            engine.initialize();

            $(this.element).typeahead(
                {
                    minLength: 3,
                    highlight: true,
                },
                {
                    source: engine.ttAdapter(),
                    displayKey: function(item){
                        return item.value;
                    },
                    templates: {
                        suggestion: function(item){
                            return item.html;
                        },
                        empty: function(){
                            return '<div class="tt-suggestion">0 Results Found</div>';
                        }
                    }
                }
            ).on('typeahead:selected', function onItemSelect(event,item,name){
                    if(item.hasOwnProperty('url')){
                        window.location.href = item.url;
                        event.preventDefault();
                    }

                    var fillableInputs = $(base.element).parent('.twitter-typeahead').siblings('input.fillable');
                    if(fillableInputs.length > 0){
                        fillableInputs.each(function(){
                            var key = $(this).attr('data-fill');
                            if(item.data.hasOwnProperty(key)){
                                $(this).val( item.data[ key ] );
                            }
                        });
                    }
                }
            );
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