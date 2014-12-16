define(['jquery', 'jquery-ui', 'datetimepicker'], function($)
{
    return function(selector, options)
    {
        function trigger(eventName)
        {
            return function(e)
            {
                var handler = $(e.currentTarget).data(eventName);
                if (handler) handler(e);
            }
        }

        options = $.extend({
            format: 'mm/dd/yy hh:ii:ss',
            autoclose: true,
            numberOfMonths: 2,
            minView: 2,
        }, options);

        $(selector).datetimepicker(options)
        .on('changeDate', trigger('onChangeDate'))
        .on('show', trigger('onShow'))
        .on('next:month ', trigger('onNextMonth'))
        .on('prev:month ', trigger('onPrevMonth'));
    }
});
