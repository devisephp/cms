define(["jquery", "bootstrap.min"], (function( $ ) {
    $('#general-tabs').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
}));