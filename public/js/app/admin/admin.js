define(['require', 'jquery'], function (require, $) {

    var initialize = function()
    {
        addDeleteConfirmation();
        calculateVignette();
        addListeners();
    };

    var addListeners = function() {
        $(window).resize(function() {
            calculateVignette();
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
