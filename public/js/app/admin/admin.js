devise.define(['require', 'jquery', 'dvsSelectSurrogate'], function (require, $, selectSurrogate) {

    var initialize = function()
    {
        addDeleteConfirmation();
        calculateVignette();
        addListeners();
        selectSurrogate();
    };

    var addListeners = function() {
        $(window).resize(function() {
            calculateVignette();
        });

        $('#lang-select').change(function(e){

            if (typeof e.isTrigger == "undefined")
            {
                var params = document.location.search.substr(1).split('&');
                var found = false;
                var newParam = 'language_id=' + $(this).val();
                for (var index in params) {
                    var keyVal = params[index].split('=');
                    if (keyVal[0] == 'language_id') {
                        found = true;
                        params[index] = newParam;
                        break;
                    }
                }
                if (!found) {
                    params.push(newParam);
                }
                document.location.search = params.join('&');
            }
        });
    };

    var addDeleteConfirmation = function()
    {
        $(document).on('submit', '.delete-form', function(){
            return confirm('Are you sure?');
        });
    };

    var calculateVignette = function() {

        var docHeight = $(document).height();
        var targetHeight = docHeight - $('#dvs-admin-top-bar').outerHeight();

        $('.vignette').css('height', targetHeight);
    };

    initialize();

});
