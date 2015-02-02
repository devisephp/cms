devise.define(['require', 'jquery', 'dvsQueryHelper'], function (require, $, query)
{
    var obj = {};

    function handleShowAdminCheckbox()
    {
        var params = query.toJson();

        params['show_admin'] = $(this).is(':checked');

        location.href = location.origin + location.pathname + query.toQueryString(params);
    }

    obj.init = function()
    {
        $('input[name="show_admin"]').change(handleShowAdminCheckbox);
    }

    obj.init();

    return obj;
});