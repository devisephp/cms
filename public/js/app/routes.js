devise.define(['jquery', 'dvsRouter'], (function($, Router)
{
    return new Router({

        'editor'        : 'click #dvs-node-mode-button',
        'sidebar/{id}'  : ['devise::sidebar', '{1}'],

    });
}));