const DevelopersIndex = () => import('../components/developers/Index')
const LanguagesManage = () => import('../components/languages/Manage')
const MetaManage = () => import('../components/meta/Manage')
const PageEditor = () => import('../components/pages/Editor')
const PagesIndex = () => import('../components/pages/Index')
const PagesView = () => import('../components/pages/View')
const SettingsIndex = () => import('../components/settings/Index')
const SitesIndex = () => import('../components/sites/Index')
const SlicesIndex = () => import('../components/slices/Index')
const TemplatesIndex = () => import('../components/templates/Index')
const TemplatesEdit = () => import('../components/templates/Edit')
const UsersIndex = () => import('../components/users/Index')
const UsersEdit = () => import('../components/users/Edit')

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
    path: '/devise/edit-page',
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
