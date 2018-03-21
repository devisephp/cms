import DevelopersIndex from '../components/developers/Index'
import LanguagesManage from '../components/languages/Manage'
import MetaManage from '../components/meta/Manage'
import PageEditor from '../components/pages/Editor'
import PagesIndex from '../components/pages/Index'
import PagesView from '../components/pages/View'
import SettingsIndex from '../components/settings/Index'
import SitesIndex from '../components/sites/Index'
import SlicesIndex from '../components/slices/Index'
import TemplatesIndex from '../components/templates/Index'
import TemplatesEdit from '../components/templates/Edit'
import UsersIndex from '../components/users/Index'
import UsersEdit from '../components/users/Edit'
// import Test from '../../../devise2-demo/resources/assets/js/components/Test'

var routes = [
  // {
  //   path: '/devise/whatever2',
  //   name: 'devise-test-adminasdfasdf',
  //   components: {
  //     'devise': Test
  //   },
  //   meta: {
  //     title: 'Testing',
  //     wide: true
  //   },
  // },
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
