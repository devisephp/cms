devise.define(['jquery'], function ($)
{
    //
    // Controls the sending via ajax of active/inactive
    // for a language to backend server
    //
    $('body').on('change', '.js-active', function(event)
    {

        var element = $(event.currentTarget);
        var active = element.is(':checked');
        var url = element.attr('data-url');

        $.ajax({
            method: 'PATCH',
            url: url,
            data: { active: active }
        });
    });

});
