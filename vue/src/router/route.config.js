// const DevelopersIndex = () => import(/* webpackChunkName: "devise-developers" */ '../components/developers/Index')
// const LanguagesManage = () => import(/* webpackChunkName: "devise-languages" */ '../components/languages/Manage')
// const MainMenu = () => import(/* webpackChunkName: "devise-mainmenu" */ '../components/menu/MainMenu')
// const MetaManage = () => import(/* webpackChunkName: "devise-meta" */ '../components/meta/Manage')
// const PageEditor = () => import(/* webpackChunkName: "devise-pages" */ '../components/pages/Editor')
// const PagesIndex = () => import(/* webpackChunkName: "devise-pages" */ '../components/pages/Index')
// const PagesView = () => import(/* webpackChunkName: "devise-pages" */ '../components/pages/View')
// const SettingsIndex = () => import(/* webpackChunkName: "devise-settings" */ '../components/settings/Index')
// const SitesIndex = () => import(/* webpackChunkName: "devise-sites" */ '../components/sites/Index')
// const TemplatesIndex = () => import(/* webpackChunkName: "devise-templates" */ '../components/templates/Index')
// const TemplatesEdit = () => import(/* webpackChunkName: "devise-templates" */ '../components/templates/Edit')
// const UsersIndex = () => import(/* webpackChunkName: "devise-users" */ '../components/users/Index')
// const UsersEdit = () => import(/* webpackChunkName: "devise-users" */ '../components/users/Edit')

import DevelopersIndex from '../components/developers/Index'
import LanguagesManage from '../components/languages/Manage'
import MainMenu from '../components/menu/MainMenu'
import MetaManage from '../components/meta/Manage'
import PageEditor from '../components/pages/Editor'
import PagesIndex from '../components/pages/Index'
import PagesView from '../components/pages/View'
import SettingsIndex from '../components/settings/Index'
import SitesIndex from '../components/sites/Index'
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
    path: '/devise/developers',
    name: 'devise-developers-index',
    components: {
      'devise': DevelopersIndex
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
