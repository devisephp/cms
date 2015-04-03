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
        // Remove new field item on click of remove button
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
        // Toggle visibility of button to add new option
        //
        $('.dvs-model-creator-form').on('change', '.dvs-form-type', function() {

            var _addChoiceBtn = $(this).nextAll('.dvs-form-group:first').find('button');

console.log(_addChoiceBtn);
            if ($(this).val() != 0) {
                _addChoiceBtn.removeClass('dvs-hidden');
            } else {
                _addChoiceBtn.addClass('dvs-hidden');
            }
        });

        //
        // Menu Accordion
        //
        $('.menu-accordion').click(function(){
            var target = $(this).data('target');
            $(target).toggle();
            if($(this).html() === '<span class="ion-android-expand"></span>'){
                $(this).html('<span class="ion-android-contract"></span>');
                $(this).parent().siblings('ol').addClass('hidden');
            } else {
                $(this).html('<span class="ion-android-expand"></span>');
                $(this).parent().siblings('ol').removeClass('hidden');
            }
        });
    }


    initialize();

});