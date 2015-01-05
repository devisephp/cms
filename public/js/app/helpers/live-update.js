devise.define(['require', 'jquery'], {getInstance: function() {

    var changes = {};
    var instance = new Object();

    function resetProperty(el, name, type, value) {
        switch(type) {
            case 'css':
                el.css(name, value);
                break;
            case 'attr':
                el.attr(name, value);
                break;
            case 'html':
            default:
                el.html(value);
                break;
        }
    }

    $('#dvs-mode').on('closeAdmin', function() {
        $.each(changes, function(updateElement, properties){
            var _el = $(updateElement);
            $.each(properties, function(propertyType, values){
                $.each(values, function(propertyName, value){
                    resetProperty(_el, propertyName, propertyType, value);
                })
            });
        });
    });

    instance.init = function($, listenTo, type) {

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
                case 'html':
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
                changes[updateSelector] = {}
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

        function updateBackgroundColor() {
            logChange('backgroundColor', 'value');
            $(updateSelector).css('backgroundColor', newValue);
        }

        function updateColor() {
            logChange('color', 'value');
            $(updateSelector).css('color', newValue);
        }

        function updateHTML() {
            logChange('html', 'value');
            $(updateSelector).html(newValue);
        }

        function updateAlternateTarget() {

            var re = /(style.)(.+)/;
            var matches = re.exec(alternateTarget);

            if (matches !== null && matches.length > 1) {
                logChange('css', matches[2]);
                $(updateSelector).css(matches[2], newValue);

            } else {
                logChange('attr', alternateTarget);
                $(updateSelector).attr(alternateTarget, newValue);
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
                    case 'color':
                        updateColor();
                        break;

                    case 'backgroundColor':
                        updateBackgroundColor();
                        break;

                    case 'link':
                    case 'text':
                    case 'textarea':
                    default:
                        updateHTML();
                        break;
                }

            } else {
                updateAlternateTarget();
            }
        }

        listenTo.bind('input', function() {
            newValue = listenTo.val();

            var _index           = listenTo.data('dvs-index');

            var _key             = listenTo.data('dvs-key');
            var _alternateTarget = listenTo.data('dvs-alternate-target');

            updateSelector       = '[data-dvs-' + _key + '-id="' + _key + '"]';
            alternateTarget      = (_alternateTarget !== null && _alternateTarget !== '') ? _alternateTarget : null;

            updateTarget();
        });
    };

    return instance;
}});
