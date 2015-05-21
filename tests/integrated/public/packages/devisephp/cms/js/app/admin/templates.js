devise.define(['jquery'], function ( $ )
{

    function initialize()
    {
        // removal of variable row listener
        $('.dvs-remove-row').on('click', function()
        {
            var varTableRow = $(this).closest('tr');
            varTableRow.remove();
        });

        // listener for individual param remove button
        $('.dvs-admin-items-wpr').on('click', '.dvs-remove-param', function()
        {
            // find 2nd parent div
            var paramWrapperDiv = $(this).parents('div:eq(1)');
            paramWrapperDiv.remove();
        });

    }

    initialize();
});