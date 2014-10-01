define(['require', 'jquery', 'dvsNetwork', 'jquery-ui'], function (require, $, network) {

    var node = null;
    var ogWidth = null;

    var sidebar = {
        init: function(_node) {
            node = _node;
            addHeader();
            ogWidth = $('#dvs-sidebar').width();
        },
        fattenUp: function() {
            $('#dvs-sidebar').width('80%');
        },
        skinnyMe: function() {
            $('#dvs-sidebar').width(ogWidth);
        },
        refresh: function() {
            $('#dvs-sidebar').trigger('sidebarUnloaded');
            addHeader();
        }
    };

    var sidebarLoaded = function(passFail) {
        if(passFail == 'done') {
            sidebarLoadSuccessful();
        } else {
            alert('The sidebar could not load the requested editor plugin')
        }
    };

    function loadDefaultData() {
        $('.dvs-editor-load-defaults').each(function(){
            var _key = $(this).data('dvs-key');
            var _type = $(this).data('dvs-type');

            var _selector = '[data-dvs-' + _key + '-id="' + _key + '"]';
            var _value = null;

            switch(_type) {
                case 'image':
                    _value = $(_selector).attr('src');
                    break;
                case 'color':
                    _value = $(_selector).css('backgroundColor');
                    break;
                case 'href':
                    _value = $(_selector).attr('href');
                    break;
                case 'target':
                    _value = $(_selector).attr('target');
                    break;

                case 'link':
                case 'text':
                case 'wysiwyg':
                case 'textarea':
                default:
                    _value = $(_selector).html();
                    break;
            }

            $(this).val(_value);
        });
    }

    function sidebarLoadSuccessful() {
        $( ".dvs-accordion" ).accordion();

        loadDefaultData();

        $('.dvs-sidebar-close').click(function(){
            $('#dvs-mode').trigger('dvsCloseAdmin');
        });

        $('#dvs-sidebar').trigger('sidebarLoaded');
    }

    function addHeader() {
        $('#dvs-sidebar-content').hide();

        network.insertTemplate('devise::admin.sidebar.main', '#dvs-sidebar', node, sidebarLoaded);
    }

    return sidebar;

});