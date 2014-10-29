define(['require', 'jquery', 'datetimepicker', 'moment'], function (require, $) {
    var formatMap = {
        'F jS Y h:i A': 'MMMM Do YYYY h:mm A',
        'F jS Y': 'MMMM Do YYYY',
        'm/d/Y h:i A': 'MM/D/YYYY h:mm A',
        'm/d/Y': 'MM/D/YYYY',
    };

    function init()
    {
        $('.dvs-datetime').each(function(){
            var parentForm = $(this).parents('form');
            var input = $(this);
            var formatInput = parentForm.find('select[name="format"]');
            var sample = input.siblings('input[name="datetime"]');


            $(this).datetimepicker({
                inline:true,
            });

            input.on('change', function()
            {
                var format = formatInput.val();
                var m = moment(input.val()).format(formatMap[format]);
                sample.val(m);
            });

            formatInput.on('change', function()
            {
                var newformat = $(this).val();
                var m = moment(input.val()).format(formatMap[newformat]);

                if (m != 'Invalid date')
                {
                    sample.val(m);
                }
            });
        });
    }

    $('#dvs-sidebar').on('sidebarLoaded', init);
    init();
});