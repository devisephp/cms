import MothershipIndex from '../components/mothership/Index'
import MothershipAnalytics from '../components/mothership/Analytics'
import MothershipBackups from '../components/mothership/Backups'
import MothershipReleases from '../components/mothership/Releases'
import MothershipChanges from '../components/mothership/Changes'
import MothershipHealthReports from '../components/mothership/HealthReports'
import LanguagesManage from '../components/languages/Manage'
import AdministrationIndex from '../components/admin/Index'
import MetaManage from '../components/meta/Manage'
import PageEditor from '../components/pages/Editor'
import PageCreate from '../components/pages/Create'
import PageSettings from '../components/pages/Settings'
import PagesIndex from '../components/pages/Index'
import PagesView from '../components/pages/View'
import SitesIndex from '../components/sites/Index'
import SitesEdit from '../components/sites/Edit'
import UsersIndex from '../components/users/Index'
import UsersEdit from '../components/users/Edit'
import RedirectsIndex from '../components/redirects/Index'
import RedirectsEdit from '../components/redirects/Edit'

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
