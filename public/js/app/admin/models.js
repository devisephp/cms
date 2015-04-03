devise.define(['jquery', 'jquery-ui', 'jqNestedSortable'], function ( $ )
{

    function initialize()
    {
        //
        // Init. sortable
        //
        var sortable = $('.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            maxLevels: 2
        });

        //
        // Add a new field row on click of add field button
        //
        $('.dvs-add-model-field').click(function() {
            var _fid = $('#dvs-fields-list li').length;
            var itemHtml = newFieldHtml.replace(/\{fid\}/g, _fid++);

            $('#dvs-fields-list').append(itemHtml);
        });

        //
        // Remove new field item on click of remove button
        //
        $('#dvs-fields-list').on('click', '.dvs-remove-field', function(event)
        {
            $(event.currentTarget).closest('.dvs-field').remove();
        });

        //
        // Remove new field row on click of remove button
        //
        $('#dvs-fields-list').on('click', '.dvs-add-choice', function(event)
        {
            var parentFieldId = $(this).closest('li.dvs-field').data('dvs-field-id');
            var choicesList = $(this).parent().next('ol.dvs-choices-list');
            var cid = choicesList.find('li').length;
            var choiceHtml = newChoiceHtml
                .replace(/\{cid\}/g, cid++)
                .replace(/\{fid\}/g, parentFieldId++);

            choicesList.append(choiceHtml);
        });

        //
        // Toggle visibility of "Add Choice" button and
        // the choices list inside relevant parent div
        //
        $('#dvs-fields-list').on('change', '.dvs-form-type', function() {
            var _opt = $(this).val();
            var _choicesElements = $('.dvs-add-choice, .dvs-choices-list, .dvs-choices-list li :input', $(this).parent('div'));

            if (_opt != 0 && _opt != 'text' && _opt != 'textarea') {

                _choicesElements.removeClass('dvs-hidden').prop('disabled', false);
            } else {

                _choicesElements.addClass('dvs-hidden').prop('disabled', true);
            }
        });

        //
        // Remove new choice item on click of remove btn
        //
        $('#dvs-fields-list').on('click', '.dvs-remove-choice', function(event)
        {
            $(event.currentTarget).closest('.dvs-choice').remove();
        });
    }

    initialize();

});