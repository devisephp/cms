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
        jqSerializeObject:  'lib/jquery-serialize-object',
        jqueryEasing:       'lib/jquery.easing.1.3',
        jcrop :             'lib/jquery.Jcrop.min',
        crossroads:         'lib/crossroads',
        signals:            'lib/signals',
        ckeditorCore:       'lib/ckeditor/ckeditor',
        ckeditorJquery:     'lib/ckeditor/adapters/jquery',
        spectrum:           'lib/spectrum',
        datetimepicker:     'lib/jquery.datetimepicker',
        handlebars:         'lib/handlebars-v3.0.0',
        moment:             'lib/moment',
        throttle:           'lib/throttle',
        fullCalendar:       'lib/fullcalendar.min',
        async:              'lib/millermedeiros-plugins/async',
        goog:               'lib/millermedeiros-plugins/goog',
        propertyParser :    'lib/millermedeiros-plugins/propertyParser',
        scrollTo:           'lib/jquery.scrollTo',
        localScroll:        'lib/jquery.localScroll.min',
        query:              'app/helpers/query',
        AttributeBinding:   'app/liveupdate/AttributeBinding',
        BindingsFinder:     'app/liveupdate/BindingsFinder',
        ClassBinding:       'app/liveupdate/ClassBinding',
        StyleBinding:       'app/liveupdate/StyleBinding',
        TextBinding:        'app/liveupdate/TextBinding',
        dvsFieldView:       'app/editor/views/field',
        dvsCollectionView:  'app/editor/views/collection',
        dvsModelView:       'app/editor/views/model',
        dvsAttributeView:   'app/editor/views/attribute',
        dvsCreatorView:     'app/editor/views/creator',
        dvsGroupView:       'app/editor/views/group',
        dvsSidebarView:     'app/editor/views/sidebar',
        dvsBreadCrumbsView: 'app/editor/views/breadcrumbs',
        dvsBaseView:        'app/editor/helpers/view',
        dvsTemplates:       'app/editor/helpers/templates',
        dvsPositionHelper:  'app/editor/helpers/positions',
        dvsLiveUpdate:      'app/editor/helpers/liveupdate',
        dvsLiveUpdater:     'app/editor/helpers/liveupdater',
        dvsEditor:          'app/editor/editor',
        dvsNetwork:         'app/helpers/network',
        dvsCsrf:            'app/helpers/csrf',
        dvsAdmin:           'app/admin/admin',
        dvsAdminView:       'app/admin/admin-view',
        dvsAdminPages:      'app/admin/pages',
        dvsAdminMenus:      'app/admin/menus',
        dvsReplacement:     'app/helpers/replacement',
        dvsModal:           'app/helpers/modal',
        dvsPageData:        'app/helpers/page-data',
        dvsDatePicker:      'app/helpers/date-picker',
        dvsSelectSurrogate: 'app/helpers/forms-select-surrogate',
        dvsCalendar:        'app/admin/calendar',
        dvsDataReplacement: 'app/bindings/data-dvs-replacement',
        dvsChangeTarget:    'app/bindings/data-change-target',
        dvsLiveSpan:        'app/helpers/livespan',
        dvsDocumentation:   'app/helpers/documentation'
    }
});