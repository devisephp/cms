devise.define(['require', 'jquery', 'dvsSelectSurrogate'], function (require, $, dvsSelectSurrogate) {
    return {
        init: function()
        {
            /*
                Event Handlers
            */
            function onBeforeSave(evt, config)
            {
                var form = $(evt.currentTarget);
                var passed = true;
                form.find('[name$="[key]"], [name$="[label]"]').each(function(){
                    if($(this).val() === ''){
                        passed = false;
                        return false;
                    }
                });
                if(!passed){
                    alert("All labels and keys require a value.");
                }
                config.continue = passed;
            }

            function onAddNewClick()
            {
                var parentForm = $(this).parents('form');
                unBindEvents(parentForm);

                addNewTableRow(parentForm);
                addNewCheckbox(parentForm);
                redefindCheckBoxIndexes(parentForm);

                $( ".dvs-accordion" ).accordion("refresh");
                bindEvents(parentForm);

                dvsSelectSurrogate();
            }

            function onDeleteclick()
            {
                var parentForm = $(this).parents('form');
                var index = $(this).parents('.dvs-checkbox-fields').index();
                unBindEvents(parentForm);

                parentForm.find('.dvs-checkboxes .dvs-checkbox:nth-child(' + (index + 1) + ')').remove();
                $(this).closest('tr').remove();
                $( ".dvs-accordion" ).accordion("refresh");

                redefindCheckBoxIndexes(parentForm);
                bindEvents(parentForm);
            }

            function onInputChange()
            {
                var parentForm = $(this).parents('form');
                var index = $(this).parents('.dvs-checkbox-fields').index();
                var target = parentForm.find('.dvs-checkboxes .dvs-checkbox:nth-child(' + (index + 1) + ')');

                if($(this).attr('name').indexOf('label') > -1){
                    target.find('span').html( $(this).val() );
                }
                if($(this).attr('name').indexOf('key') > -1){
                    target.find('input').attr('name', $(this).val());
                }
                if($(this).attr('name').indexOf('default') > -1){
                    target.find('input').prop('checked', ($(this).val() == 1));
                }
            }

            /*
                Custom Functions
            */
            function addNewTableRow(parentForm)
            {
                var newRow = $('.dvs-row-template').html();
                var index = $('.dvs-checkbox-fields').length;

                // replacing the {index} string with the new index, and removing the disabled attribute
                parentForm.find('table tbody').append(newRow);
                parentForm.find('table tbody td:last-child .dvs-table-row-delete').click(onDeleteclick);
            }

            function addNewCheckbox(parentForm)
            {
                var newCbox = $('.dvs-checkbox-template').html();

                parentForm.find('.dvs-checkboxes').append(newCbox);
            }

            function redefindCheckBoxIndexes(parentForm)
            {
                parentForm.find('.dvs-checkbox-fields').each(function(i, row){
                    $(row).find('[name^="checkboxes"]').each(function(j, input){
                        var currentName = $(input).attr('name');
                        var newName = currentName.replace(/(\d+)/g, i);
                        $(input).attr('name', newName);
                    });
                });
            }

            /*
                Event bindings
            */
            function unBindEvents(parentContainer)
            {
                parentContainer.find('.dvs-new-checkbox').unbind('click', onAddNewClick);
                parentContainer.find('.dvs-table-row-delete').unbind('click', onDeleteclick);
                parentContainer.find('.dvs-checkbox-fields input').unbind('input', onInputChange);
                parentContainer.find('.dvs-checkbox-fields select').unbind('change', onInputChange);
            }

            function bindEvents(parentContainer)
            {
                parentContainer.find('.dvs-new-checkbox').bind('click', onAddNewClick);
                parentContainer.find('.dvs-table-row-delete').bind('click', onDeleteclick);
                parentContainer.find('.dvs-checkbox-fields input').bind('input', onInputChange);
                parentContainer.find('.dvs-checkbox-fields select').bind('change', onInputChange);
            }

            bindEvents($('#dvs-sidebar'));
            $('.dvs-element-checkbox-group').on('beforeSave', onBeforeSave);
        }
    };
});