define(['jquery', 'jquery-ui'], function ()
{
    require(['jquery.nestedSortable'], function() { initialize(); });

    function updateItemParent(itemId, parentId)
    {
        var selector = '[name="item_order[' + itemId + ']"]';

        if ($(selector).length == 0)
        {
            var newInput = '<input type="hidden" name="item_order[' + itemId + ']">';
            $('.js-menu-form').append(newInput)
        }

        $(selector).val(parentId);
    }

    function initialize()
    {
        //
        // Create the nested sortable
        //
        var sortable = $('.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            maxLevels: 3
        });


        //
        // Add a new menu item button
        //
        var cid = 1;
        var newMenuItemTemplate = $('#js-menu-item-template').html();

        $('.js-add-menu-item').on('click', function()
        {
            $('.dvs-menu-items').append(newMenuItemTemplate.replace(/\{cid\}/g, 'cid' + cid++));
        });


        //
        // IMAGE MANAGER
        //
        $('.dvs-menu-items').on('click', '.media-manager', function()
        {
            var input = $(this);
            var mediaUrl = '/admin/media-manager?cropMode=Preserve&type=image';

            window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");

            document.onMediaManagerSelect = function(images){
                input.val(images);
            };
        });


        //
        // Update the menu items page
        //
        $('.js-menu-form').submit(function(event)
        {
            var ordering = sortable.nestedSortable('toArray');

            $.each(ordering, function(index, order)
            {
                if (order.item_id)
                {
                    updateItemParent(order.item_id, order.parent_id);
                }
            });

            $('[name="_data_token"]').remove();

            return true;
        });

        //
        // Remove the menu item
        //
        $('.js-menu-form').on('click', '.js-remove-menu-item', function(event)
        {
            var element = $(event.currentTarget);
            element.closest('.js-menu-item').remove();
        });
    }
});