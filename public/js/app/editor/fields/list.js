devise.define(['require', 'jquery'], function (require, $) {

    return {
        init: function()
        {
            function onAddNewClick()
            {
                var parentForm = $(this).closest('form');
                unBindEvents(parentForm);

                addNewTableRow(parentForm);
                addNewListItem(parentForm);

                $( ".dvs-accordion" ).accordion("refresh");
                bindEvents(parentForm);
            }

            function onDeleteclick()
            {
                var parentForm = $(this).closest('form');
                var index = $(this).closest('.dvs-item-fields').index();
                unBindEvents(parentForm);

                $(this).closest('tr').remove();
                $( ".dvs-accordion" ).accordion("refresh");

                bindEvents(parentForm);
            }

            function onInputChange()
            {
                var parentForm = $(this).closest('form');
                var index = $(this).closest('.dvs-item-fields').index();
                var target = parentForm.find('ul[name="value"] li:nth-child(' + (index + 1) + ')');

                if($(this).attr('name').indexOf('name') > -1){
                    target.html( $(this).val() );
                }

                if($(this).attr('name').indexOf('value') > -1){
                    target.attr('value', $(this).val());
                }
            }

            /*
                Custom Functions
            */
            function addNewTableRow(parentForm)
            {
                var newRow = $('.dvs-row-template').html();
                var index = $('.dvs-item-fields').length;

                // replacing the {index} string with the new index, and removing the disabled attribute
                parentForm.find('table tbody').append(newRow);
                parentForm.find('table tbody td:last-child .dvs-table-row-delete').click(onDeleteclick);
            }

            function addNewListItem(parentForm)
            {
                parentForm.find('ul[name="value"]').append('<li></li>');
            }

            /*
                Event bindings
            */
            function unBindEvents(parentContainer)
            {
                parentContainer.find('.dvs-new-item').unbind('click', onAddNewClick);
                parentContainer.find('.dvs-table-row-delete').unbind('click', onDeleteclick);
                parentContainer.find('.dvs-item-fields input').unbind('input', onInputChange);
            }

            function bindEvents(parentContainer)
            {
                parentContainer.find('.dvs-new-item').bind('click', onAddNewClick);
                parentContainer.find('.dvs-table-row-delete').bind('click', onDeleteclick);
                parentContainer.find('.dvs-item-fields input').bind('input', onInputChange);
            }

            bindEvents($('#dvs-sidebar'));
        }
    };
});