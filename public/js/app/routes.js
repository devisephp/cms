define(['jquery', '/packages/devise/cms/js/app/helpers/router.js'], (function($, Router)
{
    return new Router({

        'editor'        : 'click #dvs-node-mode-button',
        'sidebar/{id}'  : ['devise::sidebar', '{1}'],

    });
}));