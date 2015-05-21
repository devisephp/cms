devise.define(['jquery'], function($) {

    function updateElementText(selector, listenTo)
    {
        var element = $(selector);

        var text = listenTo.val();

        if (text === '') text = element.data('livespanDefault');

        element.text(text);
    }

    return {

        init: function()
        {
            $('[data-livespan]').each(function(index, el)
            {
                var element = $(el);

                var listenToSelector = element.data('livespan');

                var listenTo = $(listenToSelector);

                var selector = '[data-livespan="'+ listenToSelector.replace(/"/g, '') +'"]';

                element.data('livespanDefault', element.text());

                updateElementText(element, listenTo);

                listenTo.on('keyup', function()
                {
                    updateElementText(selector, listenTo);
                });
            });
        }
    };

});
