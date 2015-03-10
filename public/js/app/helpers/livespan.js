devise.define(['jquery'], function($) {

    function updateElementText(element, listenTo)
    {
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

                var listenTo = $(element.data('livespan'));

                element.data('livespanDefault', element.text());

                updateElementText(element, listenTo);

                listenTo.on('keyup', function()
                {
                    updateElementText(element, listenTo);
                });
            });
        }
    };

});
