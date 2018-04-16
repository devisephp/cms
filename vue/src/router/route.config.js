const DevelopersIndex = () => import(/* webpackChunkName: "devise-developers" */ '../components/developers/Index')
const LanguagesManage = () => import(/* webpackChunkName: "devise-languages" */ '../components/languages/Manage')
const MetaManage = () => import(/* webpackChunkName: "devise-meta" */ '../components/meta/Manage')
const PageEditor = () => import(/* webpackChunkName: "devise-pages" */ '../components/pages/Editor')
const PagesIndex = () => import(/* webpackChunkName: "devise-pages" */ '../components/pages/Index')
const PagesView = () => import(/* webpackChunkName: "devise-pages" */ '../components/pages/View')
const SettingsIndex = () => import(/* webpackChunkName: "devise-settings" */ '../components/settings/Index')
const SitesIndex = () => import(/* webpackChunkName: "devise-sites" */ '../components/sites/Index')
const TemplatesIndex = () => import(/* webpackChunkName: "devise-templates" */ '../components/templates/Index')
const TemplatesEdit = () => import(/* webpackChunkName: "devise-templates" */ '../components/templates/Edit')
const UsersIndex = () => import(/* webpackChunkName: "devise-users" */ '../components/users/Index')
const UsersEdit = () => import(/* webpackChunkName: "devise-users" */ '../components/users/Edit')

var routes = [
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
    path: '/devise/slices',
    name: 'devise-slices-index',
    components: {
      'devise': SlicesIndex
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
