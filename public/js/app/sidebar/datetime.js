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
                format:'Y-m-d H:i:s',
                inline:true,
            });

            input.change(function(){
                var format = formatInput.val();
                var m = moment(input.val()).format(formatMap[format]);
                sample.val(m);
            });

            formatInput.bind('change', function(){
                var newformat = $(this).val();
                var m = moment(input.val()).format(formatMap[newformat]);
                if(m != 'Invalid date'){
                    sample.val(m);
                } else {
                    //console.log(m);
                }
            });
        });
    }

    $('#dvs-sidebar').on('sidebarLoaded', init);
    init();
});