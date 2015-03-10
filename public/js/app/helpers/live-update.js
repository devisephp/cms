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
    // console.log( jQuery._data( jQuery('#dvs-mode')[0], "events" ) );
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
console.log('updateTarget');
                if (typeof alternateTarget === 'undefined' || alternateTarget === null)
                {
                    switch (type) {
                        case 'image':
                            updateImage();
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

console.log('editorType', editorType);



            // currently for input, textarea, link
            if (editorType !== 'wysiwyg' && editorType !== 'datetime')
            {

                listenTo.bind('input', function() {
                    newValue = listenTo.val();

                    var _index           = listenTo.data('dvs-index');
                    var _key             = listenTo.data('dvs-key');
                    var _alternateTarget = listenTo.data('dvs-alternate-target');

                    updateSelector = '[data-devise-field' + _index + '="' + _key + '"]';

                    alternateTarget = (_alternateTarget !== null && _alternateTarget !== '') ? _alternateTarget : null;

                    updateTarget();
                });

            }
            else if(editorType == 'datetime')
            {

                 $('.dvs-sidebar-datetime-element').on('change', listenTo, function() {
                    newValue = listenTo.val();

                    var _index           = listenTo.data('dvs-index');
                    var _key             = listenTo.data('dvs-key');
                    var _alternateTarget = listenTo.data('dvs-alternate-target');

                    updateSelector = '[data-devise-field' + _index + '="' + _key + '"]';

                    updateTarget();
                 });

            }
            else
            {
                // wysiwyg's

                listenTo.on('change', function() {
                    newValue = listenTo.getData();

                    var _textArea = jQuery('textarea.dvs-wysiwyg');

                    var _index           = _textArea.data('dvs-index');
                    var _key             = _textArea.data('dvs-key');
                    var _alternateTarget = _textArea.data('dvs-alternate-target');

                    updateSelector = '[data-devise-field' + _index + '="' + _key + '"]';
console.log(updateSelector);
                    alternateTarget = (_alternateTarget !== null && _alternateTarget !== '') ? _alternateTarget : null;

                    updateTarget();

                });

            }

            addAdminCloseListener();
        };

        return instance;

    }
});