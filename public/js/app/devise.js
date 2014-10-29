define(['jquery', 'dvsInitialize', 'dvsRoutes', 'dvsGlobalBus'], (function( $, dvsInitialize, dvsRoutes, dvsMessageBus) {

    var devise = {
        init: function(_pageId, _pageVersionId)
        {
            //
            // this is here as an example of how to use the message bus
            // to call this we would do dvsMessageBus.execute('devise::sidebar', 12)
            // the Router uses dvsMessageBus for array types
            //
            // This can be removed later... and is purely an example
            //
            // dvsMessageBus.addCommand('devise::sidebar', function(id)
            // {
            //     //console.log('trying to fetch sidebar with id ' + id);
            // });

            dvsInitialize(_pageId, _pageVersionId);
            dvsRoutes.start();
        }
    };

    return devise;


}));