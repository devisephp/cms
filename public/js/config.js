require.config({

    namespace: "devise",

    baseUrl: '/packages/devisephp/cms/js',

    shim:  {
        ckeditorJquery : {
            deps: ['jquery', 'ckeditorCore']
        },
        datetimepicker : {
            deps: ['jquery']
        },
        fullCalendar : {
            deps: ['jquery', 'moment']
        },
        crossroads: {
            deps: ['signals']
        }
    },

    paths: {
        jquery:             'lib/jquery',
        'jquery-ui':        'lib/jquery-ui',
        jqNestedSortable:   'lib/jquery.nestedSortable',
        jqueryEasing:       'lib/jquery.easing.1.3',
        jcrop :             'lib/jquery.Jcrop.min',
        crossroads:         'lib/crossroads',
        signals:            'lib/signals',
        ckeditorCore:       'lib/ckeditor/ckeditor',
        ckeditorJquery:     'lib/ckeditor/adapters/jquery',
        spectrum:           'lib/spectrum',
        datetimepicker:     'lib/jquery.datetimepicker',
        moment:             'lib/moment',
        throttle:           'lib/throttle',
        fullCalendar:       'lib/fullcalendar.min',
        async:              'lib/millermedeiros-plugins/async',
        goog:               'lib/millermedeiros-plugins/goog',
        propertyParser :    'lib/millermedeiros-plugins/propertyParser',
        scrollTo:           'lib/jquery.scrollTo',
        localScroll:        'lib/jquery.localScroll.min',
        dvsEditor:          'app/devise',
        dvsPublic:          'app/public/preview',
        dvsInitialize:      'app/helpers/initialize-editor',
        dvsListeners:       'app/helpers/listeners',
        dvsNetwork:         'app/helpers/network',
        dvsCsrf:            'app/helpers/csrf',
        dvsNodeView:        'app/nodes/node-view',
        dvsFloaterSidebar:  'app/nodes/floaterNodeSidebar',
        dvsAdmin:           'app/admin/admin',
        dvsSidebarView:     'app/sidebar/sidebar-view',
        dvsCollectionsView: 'app/sidebar/collections-view',
        dvsAdminView:       'app/admin/admin-view',
        dvsAdminPages:      'app/admin/pages',
        dvsAdminMenus:      'app/admin/menus',
        dvsLiveUpdate:      'app/helpers/live-update',
        dvsReplacement:     'app/helpers/replacement',
        dvsModal:           'app/helpers/modal',
        dvsQueryHelper:     'app/helpers/query-helper',
        dvsPageData:        'app/helpers/page-data',
        dvsDatePicker:      'app/helpers/date-picker',
        dvsSelectSurrogate: 'app/helpers/forms-select-surrogate',
        dvsCalendar:        'app/admin/calendar',
        dvsDataReplacement: 'app/bindings/data-dvs-replacement',
        dvsChangeTarget:    'app/bindings/data-change-target',
        dvsLiveSpan:        'app/helpers/livespan',
        dvsDocumentation:    'app/helpers/documentation'
    }
});