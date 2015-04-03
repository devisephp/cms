devise.define(['jquery', 'dvsTemplates'], function($, Templates)
{
    /**
     * Namespace for static class
     */
    var View = { data: {} };


    /**
     * This registers all the events on the given
     * el (jquery) object. Uses thisContext for
     * "this" to the called handler
     */
    View.registerEvents = function(el, events, thisContext)
    {
        $.each(events, function(index, handler)
        {
            var parts = index.split(' ');
            var type = parts.shift();
            var selector = parts.join(' ');

            var thisHandler = (typeof handler === 'string') ? thisContext[handler] : handler;

            if (typeof thisHandler !== 'function')
            {
                throw "invalid handler given: " + handler;
            }

            el.on(type, selector, function() { thisHandler.apply(thisContext, arguments); });
        });
    }

    /**
     * Makes a jquery object from the resulting
     * html string that returns from Templates.make
     */
    View.make = function(template, data)
    {
        var template = Templates.make(template, data);

        var view = $('<div/>').html(template).contents();

        View.injectPartials(view, data);

        return view;
    }

    /**
     * Renders the template and returns html string
     */
    View.render = function(template, data)
    {
        return Templates.make(template, data);
    }

    /**
     * Inject in partials into our element
     */
    View.injectPartials = function(layout, data)
    {
        layout.find('[data-partial]').each(function(index, el)
        {
            var element = $(el);

            var partial = element.data('partial');

            var view = Templates.make('sidebar.partials.' + partial, data);

            element.append(view);
        });
    }

    /**
     * Filter out data using a json search criteria
     */
    View.data.filter = function(data, searchCriteria)
    {
        var filtered = [];

        $.each(data, function(index, item)
        {
            var matchesCriteria = true;

            $.each(searchCriteria, function(key, value)
            {
                if (typeof item[key] === 'undefined' || item[key] != value)
                {
                    matchesCriteria = false;
                    return false;
                }
            });

            if (matchesCriteria) filtered.push(item);
        });

        return filtered;
    }

    /**
     * Find an item by it's id
     */
    View.data.find = function(data, id)
    {
        var found = null;

        $.each(data, function(index, item)
        {
            if (item.id == id) {
                found = item;
                return false; // break from loop
            }
        });

        return found;
    }

    return View;
});