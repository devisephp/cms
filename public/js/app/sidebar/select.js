define(['require', 'jquery'], function (require, $) {
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
                    if($(this).val() == ''){
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
                var parentForm = $(this).closest('form');
                unBindEvents(parentForm);

                addNewTableRow(parentForm);
                addNewselect(parentForm);
                redefindselectIndexes(parentForm);

                $( ".dvs-accordion" ).accordion("refresh");
                bindEvents(parentForm);
            }

            function onDeleteclick()
            {
                var parentForm = $(this).closest('form');
                var index = $(this).closest('.dvs-option-fields').index();
                unBindEvents(parentForm);

                parentForm.find('select[name="value"] option:nth-child(' + (index + 1) + ')').remove();
                $(this).closest('tr').remove();
                $( ".dvs-accordion" ).accordion("refresh");

                redefindselectIndexes(parentForm);
                bindEvents(parentForm);
            }

            function onInputChange()
            {
                var parentForm = $(this).closest('form');
                var index = $(this).closest('.dvs-option-fields').index();
                var target = parentForm.find('select[name="value"] option:nth-child(' + (index + 1) + ')');

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
                var index = $('.dvs-option-fields').length;

                // replacing the {index} string with the new index, and removing the disabled attribute
                parentForm.find('table tbody').append(newRow);
                parentForm.find('table tbody td:last-child .dvs-table-row-delete').click(onDeleteclick);
            }

            function addNewselect(parentForm)
            {
                parentForm.find('select[name="value"]').append('<option value=""></option>');
            }

            function redefindselectIndexes(parentForm)
            {
                parentForm.find('.dvs-option-fields').each(function(i, row){
                    $(row).find('[name^="options"]').each(function(j, input){
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
                parentContainer.find('.dvs-new-option').unbind('click', onAddNewClick);
                parentContainer.find('.dvs-table-row-delete').unbind('click', onDeleteclick);
                parentContainer.find('.dvs-option-fields input').unbind('input', onInputChange);
                parentContainer.find('.dvs-option-fields select').unbind('change', onInputChange);
            }

            function bindEvents(parentContainer)
            {
                parentContainer.find('.dvs-new-option').bind('click', onAddNewClick);
                parentContainer.find('.dvs-table-row-delete').bind('click', onDeleteclick);
                parentContainer.find('.dvs-option-fields input').bind('input', onInputChange);
                parentContainer.find('.dvs-option-fields select').bind('change', onInputChange);
            }

            bindEvents($('#dvs-sidebar'));

            $('.dvs-element-select-group').on('beforeSave', onBeforeSave);
        }
    };
});