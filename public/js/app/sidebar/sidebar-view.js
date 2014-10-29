define(['require', 'jquery', 'dvsDatePicker', 'dvsNetwork', 'dvsPageData', 'dvsQueryHelper', 'jquery-ui'], function (require, $, datePicker, network, pageData, query)
{
    var node = null;
    var ogWidth = null;

    var sidebar = {
        init: function(_node) {
            node = _node;
            addHeader();
            ogWidth = $('#dvs-sidebar').width();
        },
        fattenUp: function() {
            $('#dvs-sidebar').width('80%');
        },
        skinnyMe: function() {
            $('#dvs-sidebar').width(ogWidth);
        },
        refresh: function() {
            $('#dvs-sidebar').trigger('sidebarUnloaded');
            addHeader();
        }
    };

    var sidebarLoaded = function(passFail) {
        if(passFail == 'done') {
            sidebarLoadSuccessful();
        } else {
            alert('The sidebar could not load the requested editor plugin')
        }
    };

    function loadDefaultData() {
        $('.dvs-editor-load-defaults').each(function(){
            var _key = $(this).data('dvs-key');
            var _type = $(this).data('dvs-type');

            var _selector = '[data-dvs-' + _key + '-id="' + _key + '"]';
            var _value = null;

            switch(_type) {
                case 'image':
                    _value = $(_selector).attr('src');
                    break;
                case 'color':
                    _value = $(_selector).css('backgroundColor');
                    break;
                case 'href':
                    _value = $(_selector).attr('href');
                    break;
                case 'target':
                    _value = $(_selector).attr('target');
                    break;

                case 'link':
                case 'text':
                case 'wysiwyg':
                case 'textarea':
                default:
                    _value = $(_selector).html();
                    break;
            }

            $(this).val(_value);
        });
    }

    function sidebarLoadSuccessful() {
        $( ".dvs-accordion" ).accordion();

        loadDefaultData();

        addPageVersionButton();

        addChangePageVersionListener();

        addPageVersionDateRangePicker();

        $('.dvs-sidebar-close').click(function(){
            $('#dvs-mode').trigger('dvsCloseAdmin');
        });

        $('#dvs-sidebar').trigger('sidebarLoaded');
    }

    function addHeader() {
        $('#dvs-sidebar-content').hide();

        network.insertTemplate('devise::admin.sidebar.main', '#dvs-sidebar', node, sidebarLoaded);
    }

    function addPageVersionButton() {
        $('#dvs-sidebar-add-version').on('click', function() {
            var pageName = prompt('What would you like to name this new page version?');

            if (pageName)
            {
                var data = { page_version_id: pageData.page_version_id, name: pageName };
                $.post('/admin/page-versions', data).then(function(results, status, xhr)
                {
                    var href = window.location.href;

                    href += (href.indexOf('?') > 7) ? '&' : '?';
                    href += 'page_version=' + results.name;

                    window.location.href = href;
                });
            }
        });
    }

    function addChangePageVersionListener() {
        $('#dvs-sidebar-version-selector').on('change', function() {
            var json = query.toJson();

            json['page_version'] = $(this).val();

            var queryString = query.toQueryString(json);

            window.location.href = window.location.origin + window.location.pathname + queryString;
        });
    }


    function addPageVersionDateRangePicker()
    {
        datePicker('.js-datepicker', {});

        var datePickers = $('.js-datepickers');
        var adjustDates = $('.js-adjust-dates');
        var startDatePicker = $('.js-datepicker.js-start-date');
        var endDatePicker = $('.js-datepicker.js-end-date');
        var updateDatesBtn = $('.js-update-dates');
        var datePickerErrors = $('.js-datepicker-errors');

        // we don't want the user to select a date before the start date,
        // as this doesn't really make sense
        startDatePicker.data('onChangeDate', function(e)
        {
            var selectedDate = new Date(e.date.getFullYear(), e.date.getMonth(), e.date.getDate());
            endDatePicker.datetimepicker('setStartDate', selectedDate).focus();
        });

        // we can show/hide the datePickers when the user
        // clicks this button
        adjustDates.on('click', function(e)
        {
            datePickers.toggleClass('hidden');
        });

        updateDatesBtn.on('click', function(e)
        {
            var start = startDatePicker.val();
            var end = endDatePicker.val();
            var data = {
                starts_at: start,
                ends_at: end
            };

            $.ajax({
                method: 'put',
                url: updateDatesBtn.data('url'),
                data: data,
                success: function() { window.location.reload(); },
                error: function(errors) { alert('Error updating the dates for this version!'); }
            });

            datePickers.addClass('hidden');
        });
    }

    return sidebar;

});