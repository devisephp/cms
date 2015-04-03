devise.define(['require', 'jquery'], {

    getInstance: function()
    {
        var changes    = {};
        var instance   = {};
        var jquery     = null;
        var editorType = null;

        function resetProperty(el, name, type, value) {
            switch(type) {
                case 'css':
                    el.css(name, value);
                    break;
                case 'attr':
                    el.attr(name, value);
                    break;
                // case 'html':
                default:
                    el.html(value);
                    break;
            }
        }

        function addAdminCloseListener() {
            jQuery('#dvs-mode').on('closeAdmin', function() {

                jQuery.each(changes, function(updateElement, properties){
                    var _el = jQuery(updateElement);
                    jQuery.each(properties, function(propertyType, values){
                        jQuery.each(values, function(propertyName, value){
                            resetProperty(_el, propertyName, propertyType, value);
                        });
                    });
                });
            });
        }

        instance.init = function($, listenTo, type) {

            jQuery     = $;
            editorType = type;

            var updateSelector  = null;
            var alternateTarget = null;
            var newValue        = '';

            function getCurrentValue(_type, _property) {
                var _currentValue = null;

                switch (_type) {
                    case 'css':
                        _currentValue = $(updateSelector).css(_property);
                        break;

                    case 'attr':
                        _currentValue = $(updateSelector).attr(_property);
                        break;

                    case 'wysiwyg':
                        _currentValue = _property.getData();
                        break;

                    // case 'html':
                    default:
                        _currentValue = $(updateSelector).html();
                        break;
                }

                if (typeof _currentValue == 'undefined') {
                    _currentValue = null;
                }

                return _currentValue;
            }

            function logChange(_type, _property) {
                if(typeof changes[updateSelector] == 'undefined') {
                    changes[updateSelector] = {};
                }
                if(typeof changes[updateSelector][_type] == 'undefined') {
                    changes[updateSelector][_type] = {};
                }
                if(typeof changes[updateSelector][_type][_property] == 'undefined') {
                    changes[updateSelector][_type][_property] = getCurrentValue(_type, _property);
                }
            }

            function updateImage() {
                logChange('image', 'value');
                $(updateSelector).attr('src', newValue);
            }

            function updateFile() {
                logChange('file', 'value');
                $(updateSelector).attr('value', newValue);
            }

            function updateColor() {
                logChange('color', 'value');
                $(updateSelector).css('color', newValue);
            }

            function updateHTML() {
                logChange('html', 'value');
                $(updateSelector).html(newValue);
            }

            function updateDatetime() {
                logChange('datetime', 'value');
                $(updateSelector).html(newValue);
            }

            function updateAlternateTarget()
            {
                var re = /(attribute.)(.+)/;
                var matches = re.exec(alternateTarget);

                if (matches !== null && matches.length > 1) {
                    logChange('attr', matches[2]);
                    $(updateSelector).attr(matches[2], newValue);
                } else {
                    logChange('css', alternateTarget);
                    $(updateSelector).css(alternateTarget, newValue);
                }
            }

            function updateTarget()
            {
                if (typeof alternateTarget === 'undefined' || alternateTarget === null)
                {
                    switch (type) {
                        case 'image':
                            updateImage();
                            break;

                        case 'file':
                            updateFile();
                            updateHTML();
                            break;

                        case 'color':
                            updateColor();
                            break;

                        // case 'link':
                        // case 'text':
                        // case 'textarea':
                        default:
                            updateHTML();
                            break;
                    }

                } else {
                    updateAlternateTarget();
                }
            }

            /**
             * Set value of "newValue" variable
             *
             * @return {void}
             */
            function setNewValue(_value)
            {
                newValue = _value;
            }

            /**
             * Set value of "updateSelector" variable
             *
             * @param {integer}  _index
             * @param {string}  _key  Unique devise field key
             * @return {void}
             */
            function setUpdateSelector(_index, _key)
            {
                updateSelector = '[data-devise-field' + _index + '="' + _key + '"]';
            }

            /**
             * Set value of "alternateTarget" variable
             *
             * @param {string}  _alternateTarget
             * @return {void}
             */
            function setAlternateTarget(_alternateTarget)
            {
                alternateTarget = (_alternateTarget !== null && _alternateTarget !== '') ? _alternateTarget : null;
            }


            if (editorType === 'wysiwyg')
            {

                listenTo.on('change', function() {
                    setNewValue( listenTo.getData() );

                    var _textArea = jQuery('textarea.dvs-wysiwyg');

                    setUpdateSelector( _textArea.data('dvs-index'), _textArea.data('dvs-key') );

                    setAlternateTarget( _textArea.data('dvs-alternate-target') );

                    updateTarget();

                });

            } else if(editorType == 'datetime') {

                 $('.dvs-sidebar-datetime-element').on('change', listenTo, function() {
                    setNewValue( listenTo.val() );

                    setUpdateSelector( listenTo.data('dvs-index'), listenTo.data('dvs-key') );

                    updateTarget();
                 });

            } else {

                // currently: input, textarea, link, color,
                 listenTo.on('input', function() {
                    setNewValue( listenTo.val() );

                    setUpdateSelector( listenTo.data('dvs-index'), listenTo.data('dvs-key') );

                    setAlternateTarget( listenTo.data('dvs-alternate-target') );

                    updateTarget();
                });

            }

            addAdminCloseListener();
        };

        return instance;

    }
});