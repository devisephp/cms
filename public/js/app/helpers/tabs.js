devise.define(['require', 'jquery'], function (require, $) {
    var tabLinksTarget = this.tabLinksTarget || '.js-tab-links li a';
    var tabsContentTarget = this.tabsContentTarget || '.js-tab-content';

    var initialize = function () {
        addClickListener();
    };

    var addClickListener = function() {
        $('body').on('click', tabLinksTarget, function() {
            showActiveTab($(this));
        });
    };

    function showActiveTab(_this) {
        var activeTabContentTarget = _this.data('target'); // get the new content target

        $(tabLinksTarget).removeClass('dvs-active'); // remove active class from all tab links
        $(tabsContentTarget).addClass('dvs-hidden'); // hide all tab content sections

        $(activeTabContentTarget).removeClass('dvs-hidden'); // show new tab
        $(_this).addClass('dvs-active'); // make clicked link active
    }

    return initialize(tabLinksTarget);
});