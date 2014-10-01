define(['require', 'jquery'], function (require, $) {

    var navigationType     = 'dropdown'; // 'list', 'dropdown'
    var navigationLocation = 'both'; // 'sidebar', 'topbar', 'both'

    var navigationItems    = null;
    var showSideNavigation = true;
    var showTopNavigation  = true;

    var initializeAdminView = function () {
        loadNavigationItems();
        buildAdmin();
        openAdminMode();
    };

    function buildAdmin() {
        var sideMenu = buildSideMenu();
        var topMenu = buildTopMenu();

        $('#dvs-admin').append(topMenu);
        $('#dvs-admin').append(sideMenu);

        buildNavigation();
    }

    function buildSideMenu() {
        if (showSideNavigation) {
            return $('<div>').attr('id', 'dvs-admin-side-navigation');
        }

        return null;
    }

    function buildTopMenu() {
        if (showTopNavigation) {
            return $('<div>').attr('id', 'dvs-admin-top-navigation');
        }

        return null;
    }


    function buildListNavigation() {
        var navigation = $('<ul>').addClass('dvs-admin-navigation');

        $.each(navigationItems, function (label, properties) {
            var navigationItem = $('<li>');
            var link = $('<a>').attr('href', properties.url).html(label);

            navigationItem.append(link);
            navigation.append(navigationItem);
        });
        
        return navigation;
    }

    function buildSelectNavigation() {
        var navigation = $('<select>').addClass('dvs-admin-navigation');

        var navigationItem = $('<option>').attr('value', '').html('Admin Menu');
        navigation.append(navigationItem);

        $.each(navigationItems, function (label, properties) {
            var navigationItem = $('<option>').attr('value', properties.url).html(label);

            navigation.append(navigationItem);
        });
        return navigation;
    }

    function buildNavigation() {

        if (navigationType == 'list') {
            var navigation = buildListNavigation();
        } else {
            var navigation = buildSelectNavigation();
        }

        if (navigationLocation == 'sidebar' || navigationLocation == 'both') {
            $('#dvs-admin-side-navigation').append(navigation);
        }

        if (navigationLocation == 'topbar' || navigationLocation == 'both') {
            $('#dvs-admin-top-navigation').append(navigation);
        }
    }

    // @TODO Need to make an ajax call to load navigation
    function loadNavigationItems() {
        navigationItems = {
            'Manage Pages': {
                url: '/admin/dvs-pages',
                icon: null
            },
            'Six Flags': {
                url: 'http://sixflags.com',
                icon: null
            },
            'SeaWorld': {
                url: 'http://seaworld.com',
                icon: null
            }
        };
    }

    function openAdminMode() {
        $('#dvs-mode')
            .removeClass('dvs-node-mode dvs-sidebar-mode')
            .addClass('dvs-admin-mode');
    }

    return initializeAdminView;
});