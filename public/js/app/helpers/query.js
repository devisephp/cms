devise.define(['jquery'], (function($)
{
    var query = {};

    /**
     * Get the string as a json data object
     */
    query.toJson = function(string)
    {
        if (typeof string === 'undefined') {
            string = window.location.search.substr(1);
        }

        var a = string.split('&');
        var b = {};

        if (a == "") return {};

        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=', 2);

            if (p.length == 1) b[p[0]] = "";
            else b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }

        return b;
    };

    /**
     * Get the json data as a query string
     */
    query.toQueryString = function(jsonData)
    {
        if (typeof jsonData === 'undefined') jsonData = {};

        var params = '';

        $.each(jsonData, function(index, element) {
            params += '&' + index + '=' + encodeURIComponent(element);
        });

        return params.replace('&', '?');
    };

    /**
     * Get the parameter by name
     */
    query.get = function(name, defaults)
    {
        defaults = (typeof defaults === 'undefined') ? null : defaults;
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);

        return results == null ? defaults : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    /**
     * Append this name, value pair onto the end of this url
     */
    query.append = function(name, value, url)
    {
        var prefix = url.indexOf('?') === -1 ? '?' : '&';

        return url + prefix + name + '=' + encodeURIComponent(value);
    }

    return query;
}));
