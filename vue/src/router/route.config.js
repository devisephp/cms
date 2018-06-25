import MothershipIndex from '../components/mothership/Index'
import MothershipAnalytics from '../components/mothership/Analytics'
import MothershipBackups from '../components/mothership/Backups'
import MothershipReleases from '../components/mothership/Releases'
import MothershipChanges from '../components/mothership/Changes'
import MothershipHealthReports from '../components/mothership/HealthReports'
import LanguagesManage from '../components/languages/Manage'
import MainMenu from '../components/menu/MainMenu'
import MetaManage from '../components/meta/Manage'
import PageEditor from '../components/pages/Editor'
import PagesIndex from '../components/pages/Index'
import PagesView from '../components/pages/View'
import SettingsIndex from '../components/settings/Index'
import SitesIndex from '../components/sites/Index'
import SitesEdit from '../components/sites/Edit'
import TemplatesIndex from '../components/templates/Index'
import TemplatesEdit from '../components/templates/Edit'
import UsersIndex from '../components/users/Index'
import UsersEdit from '../components/users/Edit'

var routes = [
  {
    path: '/devise',
    name: 'devise-index',
    components: {
      'devise': MainMenu
    }
  },
  {
    path: '/devise/pages',
    name: 'devise-pages-index',
    components: {
      'devise': PagesIndex
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/pages/:pageId',
    name: 'devise-pages-view',
    components: {
      'devise': PagesView
    },
    meta: {
      wide: true
    }
  },
  {
    path: '*',
    name: 'devise-page-editor',
    components: {
      'devise': PageEditor
    }
  },
  {
    path: '/devise/mothership',
    name: 'devise-mothership-index',
    components: {
      'devise': MothershipIndex
    }
  },
  {
    path: '/devise/mothership/analytics',
    name: 'devise-ms-analytics-index',
    components: {
      'devise': MothershipAnalytics
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/mothership/releases',
    name: 'devise-ms-releases-index',
    components: {
      'devise': MothershipReleases
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/mothership/changes',
    name: 'devise-ms-changes-index',
    components: {
      'devise': MothershipChanges
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/mothership/analytics',
    name: 'devise-ms-backups-index',
    components: {
      'devise': MothershipBackups
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/mothership/health-reports',
    name: 'devise-ms-healthreports-index',
    components: {
      'devise': MothershipHealthReports
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/settings/languages',
    name: 'devise-languages-manage',
    components: {
      'devise': LanguagesManage
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/settings/meta',
    name: 'devise-meta-manage',
    components: {
      'devise': MetaManage
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/settings',
    name: 'devise-settings-index',
    components: {
      'devise': SettingsIndex
    }
  },
  {
    path: '/devise/templates',
    name: 'devise-templates-index',
    components: {
      'devise': TemplatesIndex
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/templates/:templateId/edit',
    name: 'devise-templates-edit',
    components: {
      'devise': TemplatesEdit
    },
    props: true,
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/sites',
    name: 'devise-sites-index',
    components: {
      'devise': SitesIndex
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/sites/:siteId/edit',
    name: 'devise-sites-edit',
    components: {
      'devise': SitesEdit
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/users',
    name: 'devise-users-index',
    components: {
      'devise': UsersIndex
    },
    meta: {
      wide: true
    }
  },
  {
    path: '/devise/users/:userId/edit',
    name: 'devise-users-edit',
    components: {
      'devise': UsersEdit
    },
    props: true,
    meta: {
      wide: true
    }
  }
]

export default routes
