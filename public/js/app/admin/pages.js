define(['require', 'jquery', 'dvsAdmin'], function (require, $) {

    var initialize = function() {
        addListeners();
    }

    var addListeners = function() {
        $('#show-advanced').change(function(){
            toggleAdvanced($(this).prop('checked'));
        });
        $('#http-verb').change(function(){
            toggleTemplate($(this).val());
            toggleResponse($(this).val());
        });
    }

    var toggleAdvanced = function(state) {

        if(state) {
            $('.dvs-advanced').addClass('open');
        } else {
            $('.dvs-advanced').removeClass('open');
        }
    }

    var toggleTemplate = function(verb) {
        if (verb == 'get') {
            $('#view-template-form').addClass('open');
        } else {
            $('#view-template-form').removeClass('open');
        }
    }

    var toggleResponse = function(verb) {
        if (verb == 'get') {
            $('#response-path-form').removeClass('open');
            $('#response-params-form').removeClass('open');
        } else {
            $('#response-path-form').addClass('open');
            $('#response-params-form').addClass('open');
        }
    }

    initialize();
});