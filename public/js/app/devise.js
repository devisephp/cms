devise.define(['jquery', 'dvsInitialize'], (function( $, dvsInitialize) {

    var devise = {
        init: function(_pageId, _pageVersionId)
        {
            dvsInitialize(_pageId, _pageVersionId);
        }
    };

    return devise;

}));