define(['jquery', 'app/bindings/data-dvs-replacement'], function ($)
{

    // handles admin sub nav links show/hide
    $('#dvs-admin-toggle img').click(function() {
        if($('#dvs-admin-sublinks').is(':visible')) {
            $('#dvs-admin-sublinks').fadeOut();
        } else {
            $('#dvs-admin-sublinks').fadeIn();
        }
    });

    $('#dvs-admin-body').click(function(){
        if($('#dvs-admin-sublinks').is(':visible')) {
            $('#dvs-admin-sublinks').fadeOut();
        }
    });

});
