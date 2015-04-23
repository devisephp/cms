devise.define(['require', 'jquery', 'query'], function (require, $, query)
{
    var obj = {};

    function handleShowAdminCheckbox()
    {
        var params = query.toJson();

        params['show_admin'] = $(this).is(':checked');

        location.href = location.origin + location.pathname + query.toQueryString(params);
    }

    function addContentRequestedListeners()
    {
        $('.dvs-content-requested-mark-done').click(function(){

            var action = $(this).data('url');
            var _this = this;

            $.ajax(
            {
                url: action,
                type: 'GET',
                success: function(data, textStatus, jqXHR)
                {
                    $(_this).parent().fadeOut();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert('There was a problem with your request');
                }
            });
        });
    }

    obj.init = function()
    {
        $('input[name="show_admin"]').change(handleShowAdminCheckbox);

        addContentRequestedListeners();
    };

    obj.init();

    return obj;
});