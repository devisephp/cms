devise.define(["jquery"], function ( $ ) {
    // Setting of defaults
    var pluginName = "cloneFieldValues",
        defaults = { };

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
        init: function () {

            this._addClickEventHandler();

        },

        /**
         * Get all inputs inside "#clone-fields"
         * @return {void}
         */
        getInputs: function ()
        {
            // psuedo ":input" selector retrieves all types of form fields
            var inputs = $('#clone-fields :input');

            // build an array of source field names
            this._buildFieldNamesArray(inputs);
        },

        /**
         * Iterate through inputs and get "data-source-name" attribute
         * @param {array} inputs
         * @return {void}
         */
        _buildFieldNamesArray: function(inputs)
        {
            $(inputs).each(function(){
                sourceFieldName = $(this).attr('data-source-name');
                $(this).val($(':input[name="'+sourceFieldName+'"]').val());
            });
        },

        /**
         * Set event listener on clicked element
         * @return {void}
         */
        _addClickEventHandler: function()
        {
            var base = this;

            $(this.element).click(function(){
                base.getInputs();
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
