devise.define(['jquery', 'jquery-ui', 'jqNestedSortable'], function ( $, jqUi, autocomplete)
{
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

        // menu-accordion
        $('.menu-accordion').click(function(){
            var target = $(this).data('target');
            $(target).toggle();
            if($(this).html() == '-'){
                $(this).html('v');
            } else {
                $(this).html('-');
            }
        });

        $('.dvs-menu-items').on('change', '.url-or-page', function() {
            var _selection = $(this).val();

            if (_selection == 'url') {
                $(this).siblings('.menu-item-url').removeClass('hidden');
                $(this).siblings('.menu-item-page').addClass('hidden');
            } else {
                $(this).siblings('.menu-item-page').removeClass('hidden');
                $(this).siblings('.menu-item-url').addClass('hidden');
            }
        });

        var autoCompleteSource = function (request, response) {
            $.ajax({
                url: autocompletePagesUrl,
                dataType: "json",
                type: 'get',
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                }
            });
        };

        var autoCompleteSelect = function( event, ui ) {
            event.preventDefault();

            var _id = ui.item.value;
            var _label = ui.item.label;
            $(this).siblings('input[type=hidden]').val(_id);
            $(this).val(_label);
        };

        $( ".autocomplete-pages" ).autocomplete({
            source: autoCompleteSource,
            minLength: 2,
            select: autoCompleteSelect,
            delay: 200
        });

        $('.autocomplete-pages').on('input', function() {
            $(this).siblings('input[type=hidden]').val('');
        });
    }

    initialize();
});