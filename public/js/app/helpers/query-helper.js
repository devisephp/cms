define([], (function()
{
    var query = {};

    query.toJson = function(string)
    {
        if (typeof string === 'undefined')
        {
            string = window.location.search.substr(1).split('&');
        }

        var a = string;

        if (a == "") return {};
        var b = {};

        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=', 2);
            if (p.length == 1)
                b[p[0]] = "";
            else
             b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }

        return b;
    };

    query.toQueryString = function(jsonData)
    {
        if (typeof jsonData === 'undefined')
        {
            jsonData = {};
        }

        var params = '';

        $.each(jsonData, function(index, element)
        {
            params += '&' + index + '=' + encodeURIComponent(element);
        });

        return params.replace('&', '?');
    };

    return query;
}));
