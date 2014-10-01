define([], function ()
{
    return function(name, defaults)
    {
        defaults = (typeof defaults === 'undefined') ? null : defaults;
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    
        return results == null ? defaults : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
});