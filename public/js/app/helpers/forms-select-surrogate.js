define(['require', 'jquery'], function (require, $)
{

    var initSurrogate = function()
    {
        var elements = $('.dvs-select');

        applySurrogates(elements);
    };

    function applySurrogates(elements)
    {
        $.each(elements, function(index, el) {
            if($(this).parents('.dvs-select-wrapper').length == 0){
                $(this).wrap("<span class='dvs-select-wrapper'></span>");
                $(this).after("<span class='dvs-holder'></span>");

                addListeners(this);
            }
        });
    }

    function addListeners(el) {
        $(el).change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".dvs-holder").text(selectedOption);
        }).trigger('change');
    }

    return initSurrogate;


});