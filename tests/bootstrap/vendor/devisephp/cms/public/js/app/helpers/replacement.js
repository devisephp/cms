devise.define(['jquery'], function($)
{
    var defaults = {
        previousUrl: '',                                // we don't call ajax if previous == current filter
        baseUrl: window.location.href,                  // this base url is used to attach filters to
        filterSelector: '[name^="dvs-filters"]',        // this lets us find other filters on the page
        replacementSelector: '[data-dvs-replacement]',  // lets us know where the replacementSelector binding
        urlSelector: '[data-dvs-replacement-url]'      // lets us know where the url override selector is (defaults to baseUrl)
    };

    /**
     * Allows users to configure this thing with override
     * settings that are local only to the context of this
     * handler (we don't want to pollute other handlers if
     * there are any)
     */
    return function(options)
    {
        var settings = $.extend(defaults, options);

        function onSuccess(element, body, textStatus, jqXHR)
        {
            var page = $(body);
            var selectors = getSelectors(element.attr(withNoBrackets(settings.replacementSelector)));

            for (var index in selectors)
            {
                var selector = selectors[index];
                var html = page.find(selector).html();
                $(selector).empty().append(html);
            }

            //@TODO Need to assign table row classes
            //deviseAdmin.assignTableRowClasses();
        }

        function onError()
        {
            console.warn('incurred an error!?', arguments);
        }

        /**
         * This is the handler that handles events made
         * to handle this replacement dom stuff
         */
        function handler(e)
        {
            var element = $(e.currentTarget);
            var currentUrl = getUrl(element.attr(withNoBrackets(settings.urlSelector)));

            if (settings.previousUrl != currentUrl)
            {
                $.ajax({
                    type: 'GET',
                    url: currentUrl,
                    success: function(body, textStatus, jqXHR) { return onSuccess(element, body, textStatus, jqXHR); },
                    error: function(body, textStatus, jqXHR) { return onError(element, body, textStatus, jqXHR); },
                });
            }

        }

        /**
         * We can dynamically replace different selectors
         * on our page once the ajax call is complete
         */
        function getSelectors(selectors)
        {
            // replaces spaces too, not that it probably matters, but just to be clean
            return selectors.split(',').map(function(value, index) { return value.trim(); })
        }

        /**
         * This function gets all the filters on the page
         * and creates a dynamically created url to fetch
         * the new data from
         */
        function getUrl(overrideUrl)
        {
            var url = typeof overrideUrl !== 'undefined' ? overrideUrl : settings.baseUrl;
            var filters = {};
            var filter = url.indexOf('?') == -1 ? '?' : '&';
            var noFiltersApplied = true;

            // get all the filters of the page and tack it onto the current url
            $(settings.filterSelector).each(function(index, element)
            {
                var $element = $(element);
                filters[$element.attr('name')] = $element.val();

                if ($element.val().length > 0) noFiltersApplied = false;
            });

            filter += $.param(filters);

            // get rid of the hash tag if there is one that has made its
            // way into the url, there might be a better way to do this
            // but for now we are just replacing the first instance of #
            url = url.replace('#', '');

            // notice the &page=1 here, it is here because
            // if there are no filters then we don't need to
            // try and force the first page of the search
            // if we don't do this, then we get some unexpected
            // behavior, like trying to find the 3rd page of a
            // very specific filter would return 0 results since
            // there is only results on the 1st page
            return url + filter + '&page=1';
            // return noFiltersApplied ? url : url + filter + '&page=1';
        }

        /**
         * you can't do element.attr('[data-foo]') that won't work
         * but you can do element.attr('data-foo') so that is
         * why this function exists
         */
        function withNoBrackets(string)
        {
            return string.trim().replace(/^\[/, '').replace(/\]$/, '');
        }

        /**
         * Finally we return the handler that will be executed anytime
         * jquery.on('...') is triggered
         */
        return handler;
    }

});