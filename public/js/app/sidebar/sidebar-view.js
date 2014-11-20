define(['require', 'jquery', 'dvsDatePicker', 'dvsNetwork', 'dvsPageData', 'dvsQueryHelper', 'dvsSelectSurrogate', 'jquery-ui'], function (require, $, datePicker, network, pageData, query, selectSurrogate)
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
            alert('The sidebar could not load the requested editor plugin');
        }
    };

    var elementLoaded = function(passFail) {
        if(passFail == 'done') {
            showElement();
        } else {
            alert('The element could not load the requested editor plugin');
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

                // case 'link':
                // case 'text':
                // case 'wysiwyg':
                // case 'textarea':
                default:
                    _value = $(_selector).html();
                    break;
            }

            $(this).val(_value);
        });
    }

    function setBreadcrumbs(activeLabel) {
        var link = $('<a href="javascript:void(0)">').html('All Editors');
        var span = $('<span>').html('&nbsp;');

        link.append(span);

        $('#dvs-sidebar-breadcrumbs').html(link);
        $('#dvs-sidebar-breadcrumbs').append(activeLabel);
        $('#dvs-sidebar-breadcrumbs').children('a').click(function(){
            hideElement();
        });
    }

    function showBreadcrumbs() {
        $('#dvs-sidebar-breadcrumbs').fadeIn();
    }

    function hideBreadcrumbs() {
        $('#dvs-sidebar-breadcrumbs').fadeOut();
    }

    function showElement() {
        $('#dvs-sidebar-elements-and-groups').fadeOut(function(){
            $('#dvs-sidebar-current-element').fadeIn();
            showBreadcrumbs();
        });
    }

    function hideElement() {
        hideBreadcrumbs();
        hideCollections();

        $('#dvs-sidebar-current-element').fadeOut(function(){
            $('#dvs-sidebar-elements-and-groups').fadeIn();
        });
    }

    function openElementEditor(el) {
        var _data = {
            field_id : el.data('field-id')
        };

        setBreadcrumbs(el.html());

        network.insertElement(_data, '#dvs-sidebar-current-element', elementLoaded);
    }

    function showCollections() {
        $('#dvs-sidebar-elements-and-groups').fadeOut(function(){
            $('#dvs-sidebar-collections').fadeIn();
            showBreadcrumbs();
        });
    }

    function hideCollections() {
        $('#dvs-sidebar-collections').fadeOut();
    }

    function openCollectionsManager(el) {
        setBreadcrumbs(el.html());
        showCollections();
    }

    function addListeners() {
        // Close sidebar
        $('.dvs-sidebar-close').click(function(){
            $('#dvs-mode').trigger('dvsCloseAdmin');
        });

        // Elements
        $('.dvs-sidebar-elements button').click(function(){
            openElementEditor($(this));
        });

        // Manage
        $('#dvs-sidebar-manage-groups').click(function() {
            openCollectionsManager($(this));
        });
    }

    function sidebarLoadSuccessful() {
        loadDefaultData();

        addPageVersionButton();

        addChangePageVersionListener();

        addPageVersionDateRangePicker();

        selectSurrogate();

        addListeners();

        $('#dvs-sidebar').addClass('loaded');

        $('#dvs-sidebar').trigger('sidebarLoaded');
    }

    function addHeader() {
        $('#dvs-sidebar').removeClass('loaded');

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
