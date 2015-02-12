devise.define(['jquery', 'fullCalendar', 'jquery-ui', 'datetimepicker'], function ($, fullCalendar)
{
    //
    // we need to keep the date formats consistent especially
    // when communicating back and forth between server and client
    //
    var THE_DATE_FORMAT = 'YYYY-MM-DD HH:mm:ss';
    // using the form rendered in the js-template to retrieve our csrf_token
    var csrf_token = $('input[name="_token"]').val();

    //
    // this shows the calendar modal
    //
    function showModal()
    {
        $('.modal')
            .css('opacity', '0')
            .css('top', '50%')
            .css('left', '50%')
            .fadeTo(500, 1);

        $('body')
            .append('<div id="modal-blind" />')
            .find('#modal-blind')
            .css('opacity', '0')
            .fadeTo(500, 0.8)
            .click(function(e){ closeModal(); });

        $('.modal .close,.btn-close').click(function(e)
        {
            e.preventDefault();
            closeModal();
        });
    }


    //
    // this closes the active calendar modal
    //
    function closeModal()
    {
        $('.modal').fadeOut(250, function()
        {
            $(this).css('top', '-1000px').css('left', '-1000px');
        });

        $('#modal-blind').fadeOut(250, function()
        {
            $(this).remove();
        });
    }


    //
    // this is what we do when events are clicked on
    //
    function onEventClick(event, jsEvent, view, selector)
    {
        // need to populate the values from event into this template
        var template = renderTemplate($('.edit-page-version.js-template').html(), {'event': event});

        // next we need to inject the template into the modal
        $('.modal').html(template);

        // render javascript plugins on this new html inside the modal
        $('.datetimepicker').datetimepicker({
            format:'Y-m-d H:i:s',
            style: 'z-index: 10001'
        });

        // updating an event processes the form inside the modal
        $('.modal form').on('submit', function(e)
        {
            e.preventDefault();

            var form = $('.modal form');
            var method = form.attr('method');
            var action = form.attr('action');
            var data = serializeForm(form);

            // we don't want them clicking the button again
            form.find('.js-save-btn').prop("disabled", true);

            // update the events via ajax
            $.ajax(
            {
                url: action,
                type: method,
                data: data,
                success: function(data, textStatus, jqXHR)
                {
                    xhrEventUpdateSuccess(data, event, selector);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    xhrEventUpdateFailure(errorThrown);
                    form.find('.js-save-btn').prop("disabled", false);
                }
            });
        });

        // next show the modal
        showModal();
    }


    //
    // Serialize the form inputs into a key-value pair object
    //
    function serializeForm(form)
    {
        var data = {};
        var serialized = form.serializeArray();

        // makes a variable called data with all form fields in it
        for (var index in serialized)
        {
            data[serialized[index].name] = serialized[index].value;
        }

        return data;
    }


    //
    // when an event is dropped onto the calendar
    // we call this function
    //
    function onEventReceived(event, selector)
    {
        var start = event.start.format(THE_DATE_FORMAT);

        var data = {
            start: start,
            end: null,
            title: event.title,
            published: true,
            _token: csrf_token,
        };

        $.ajax(
        {
            url: event.update_url,
            type: 'PATCH',
            data: data,
            success: function(data, textStatus, jqXHR)
            {
                xhrEventUpdateSuccess(data, event, selector);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                xhrEventUpdateFailure();
            }
        });
    }


    //
    // called whenever the event fails to update on the server side
    //
    function xhrEventUpdateFailure(errorThrown)
    {
        alert('ERROR: ' + errorThrown);
    }


    //
    // this is called anytime an event is updated on the server side
    //
    function xhrEventUpdateSuccess(data, event, selector)
    {
        if (data.published)
        {
            // update the event data since we updated it on server-side
            event.start = data.start;
            event.end = data.end;
            event.title = data.title;

            selector.fullCalendar( 'updateEvent', event );
        }
        else
        {
            selector.trigger('removeEvent', event, renderTemplate);
            selector.fullCalendar( 'removeEvents', [ event.id ]);
        }

        closeModal();
    }


    //
    // when an event is moved around the calendar and dropped
    // we need to change the time/date of that event on server side
    //
    function onEventDrop(event, delta, revertFunc, selector)
    {
        var start = event.start ? event.start.format(THE_DATE_FORMAT) : '';
        var end = event.end ? event.end.format(THE_DATE_FORMAT) : '';

        var data = {
            start: start,
            end: end,
            title: event.title,
            published: true,
            _token: csrf_token
        };

        $.ajax(
        {
            url: event.update_url,
            type: 'PATCH',
            data: data,
            success: function(data, textStatus, jqXHR)
            {
                xhrEventUpdateSuccess(data, event, selector);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                xhrEventUpdateFailure();
            }
        });
    }


    //
    // renders our template with all the data variables
    // quick/easy way to do templating in JS
    //
    function renderTemplate(template, data)
    {
        var matches = template.match(/{[._A-Za-z0-9]*}/g);

        $.each(matches, function(matchIndex, match)
        {
            var matched = match.replace('{', '').replace('}', '').split('.');
            var value = data;

            for (var index in matched)
            {
                value = typeof value === 'undefined' || value === null ? null : value[matched[index]];
            }

            if (value === null) value = '';

            // convert this to proper string format using momemnt
            if (typeof value !== 'undefined' && typeof value._isAMomentObject !== 'undefined' && value._isAMomentObject)
            {
                value = value.format(THE_DATE_FORMAT);
            }

            template = template.replace(match, value);
        });

        return template;
    }


    //
    // return the calendar object to get things rolling
    //
    return {

        //
        // initialize calendar method
        //
        init: function(selector)
        {
            // page version events come from this url
            var pageVersionSource = { url: '/admin/calendar/sources/page-versions' };

            // register the full calendar on the selector
            var $selector = $(selector);

            $selector.fullCalendar(
            {
                columnFormat: {month: 'dddd'},
                eventSources: [ pageVersionSource ],
                editable: true,
                droppable: true,
                resizable: true,
                drop: function() { $(this).remove(); },
                eventReceive: function(event) { onEventReceived(event, $selector); },
                eventClick: function(event, jsEvent, view) { onEventClick(event, jsEvent, view, $selector); },
                eventDrop: function(event, delta, revertFunc) { onEventDrop(event, delta, revertFunc, $selector); }
            });
        },

        //
        // external events can be dragged on the calendar
        //
        addDraggable: function(selector)
        {
            // draggable selector
            var $selector = $(selector);

            // register the draggable stuff for full calendar
            // so we can drag stuff on it
            $selector.each(function()
            {
                // store data so the calendar knows to render an event upon drop
                $(this).data('event',
                {
                    title: $(this).data('title'),
                    update_url: $(this).data('updateUrl'),
                    allDay: false
                });

                // make this a draggable item
                $(this).draggable({
                    zIndex: 999,
                    revert: true,
                    revertDuration: 0
                });
            });
        }
    };
});