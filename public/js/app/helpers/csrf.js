devise.define(['jquery'], function ($, datetimepicker)
{
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});