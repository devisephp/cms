devise.define(["jquery", "datepicker"], (function( $ ) {
    $('input.date.time').datetimepicker();
    $('input.date').datetimepicker({pickTime: false});
}));