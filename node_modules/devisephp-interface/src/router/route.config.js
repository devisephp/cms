const MothershipIndex = () => import(/* webpackChunkName: "js/devise-mothership" */ '../components/mothership/Index')
const MothershipAnalytics = () => import(/* webpackChunkName: "js/devise-mothership" */ '../components/mothership/Analytics')
const MothershipBackups = () => import(/* webpackChunkName: "js/devise-mothership" */ '../components/mothership/Backups')
const MothershipReleases = () => import(/* webpackChunkName: "js/devise-mothership" */ '../components/mothership/Releases')
const MothershipChanges = () => import(/* webpackChunkName: "js/devise-mothership" */ '../components/mothership/Changes')
const MothershipHealthReports = () => import(/* webpackChunkName: "js/devise-mothership" */ '../components/mothership/HealthReports')
const LanguagesManage = () => import(/* webpackChunkName: "js/devise-languages" */ '../components/languages/Manage')
const AdministrationIndex = () => import/* webpackChunkName: "js/devise-administration" */ ('../components/admin/Index')
const MetaManage = () => import(/* webpackChunkName: "js/devise-meta" */ '../components/meta/Manage')
const PageEditor = () => import(/* webpackChunkName: "js/devise-pages" */ '../components/pages/Editor')
const PageCreate = () => import(/* webpackChunkName: "js/devise-pages" */ '../components/pages/Create')
const PageSettings = () => import(/* webpackChunkName: "js/devise-pages" */ '../components/pages/Settings')
const PagesIndex = () => import(/* webpackChunkName: "js/devise-pages" */ '../components/pages/Index')
const PagesView = () => import(/* webpackChunkName: "js/devise-pages" */ '../components/pages/View')
const SitesIndex = () => import(/* webpackChunkName: "js/devise-sites" */ '../components/sites/Index')
const SitesEdit = () => import(/* webpackChunkName: "js/devise-sites" */ '../components/sites/Edit')
const UsersIndex = () => import(/* webpackChunkName: "js/devise-users" */ '../components/users/Index')
const UsersEdit = () => import(/* webpackChunkName: "js/devise-users" */ '../components/users/Edit')
const RedirectsIndex = () => import(/* webpackChunkName: "js/devise-redirects" */ '../components/redirects/Index')
const RedirectsEdit = () => import(/* webpackChunkName: "js/devise-redirects" */ '../components/redirects/Edit')

var routes = [
  {
    path: '/devise-settings',
    name: 'devise-settings',
    components: {
      'devise': AdministrationIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise-models',
    name: 'devise-models',
    components: {
      'devise': AdministrationIndex
    },
    meta: {
      parentRouteName: 'devise-models'
    }
  },
  {
    path: '/devise/pages',
    name: 'devise-pages-index',
    components: {
      'devise': PagesIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/pages/create',
    name: 'devise-pages-create',
    components: {
      'devise': PageCreate
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/pages/:pageId',
    name: 'devise-pages-view',
    components: {
      'devise': PagesView
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/',
    alias: '*',
    name: 'devise-page-editor',
    components: {
      'devise': PageEditor
    },
    meta: {
      parentRouteName: 'devise-page-editor'
    }
  },
  {
    path: '/devise/page/settings',
    name: 'devise-page-settings',
    components: {
      'devise': PageSettings
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/mothership',
    name: 'devise-mothership-index',
    components: {
      'devise': MothershipIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/mothership/analytics',
    name: 'devise-ms-analytics-index',
    components: {
      'devise': MothershipAnalytics
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/mothership/releases',
    name: 'devise-ms-releases-index',
    components: {
      'devise': MothershipReleases
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/mothership/changes',
    name: 'devise-ms-changes-index',
    components: {
      'devise': MothershipChanges
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/mothership/analytics',
    name: 'devise-ms-backups-index',
    components: {
      'devise': MothershipBackups
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/mothership/health-reports',
    name: 'devise-ms-healthreports-index',
    components: {
      'devise': MothershipHealthReports
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/settings/languages',
    name: 'devise-languages-manage',
    components: {
      'devise': LanguagesManage
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/settings/meta',
    name: 'devise-meta-manage',
    components: {
      'devise': MetaManage
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/settings',
    name: 'devise-settings-index',
    components: {
      'devise': AdministrationIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/sites',
    name: 'devise-sites-index',
    components: {
      'devise': SitesIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/sites/:siteId/edit',
    name: 'devise-sites-edit',
    components: {
      'devise': SitesEdit
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/users',
    name: 'devise-users-index',
    components: {
      'devise': UsersIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/users/:userId/edit',
    name: 'devise-users-edit',
    components: {
      'devise': UsersEdit
    },
    meta: {
      parentRouteName: 'devise-settings'
    },
    props: true
  },
  {
    path: '/devise/redirects',
    name: 'devise-redirects-index',
    components: {
      'devise': RedirectsIndex
    },
    meta: {
      parentRouteName: 'devise-settings'
    }
  },
  {
    path: '/devise/redirects/:redirectId/edit',
    name: 'devise-redirects-edit',
    components: {
      'devise': RedirectsEdit
    },
    meta: {
      parentRouteName: 'devise-settings'
    },
    props: true
  }
]

export default routes
