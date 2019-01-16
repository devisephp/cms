var tinycolor = require('tinycolor2');

const getters = {
  breakpoint: state => {
    return state.breakpoint.breakpoint;
  },

  breakpointAndDimensions: state => {
    return state.breakpoint;
  },

  // This takes a component name and returns the corresponding component from
  // deviseSettings.$deviseComponents. This contains the name, template, and field
  // configuration.
  component: state => name => {
    return deviseSettings.$deviseComponents[name];
  },

  componentFromView: state => view => {
    for (var component in deviseSettings.$deviseComponents) {
      if (deviseSettings.$deviseComponents[component].view === 'slices.' + view) {
        return deviseSettings.$deviseComponents[component];
      }
    }
    return false;
  },

  deviseInterface: state => {
    return deviseSettings.$interface;
  },

  sliceConfig: state => slice => {
    return deviseSettings.$deviseComponents[slice.metadata.name]
      ? deviseSettings.$deviseComponents[slice.metadata.name]
      : deviseSettings.$deviseComponents[slice.name];
  },

  fieldConfig: (state, getters) => ({ fieldKey, slice }) => {
    let sliceConfig = getters.sliceConfig(slice);
    if (typeof sliceConfig.config[fieldKey] !== 'undefined') {
      return sliceConfig.config[fieldKey];
    }
  },

  // Languages
  languages: state => {
    return state.languages;
  },

  lang: state => {
    return deviseSettings.$lang;
  },

  // Media Regeneration
  mediaAlreadyRequested: state => newRequest => {
    return state.mediaRegenerationRequests.find(request => {
      return (
        request.component === newRequest.component && request.fieldName === newRequest.fieldName
      );
    });
  },

  // Media manager

  files: state => {
    return state.files;
  },

  directories: state => {
    return state.directories;
  },

  searchableMedia: state => {
    return state.searchableMedia;
  },

  currentDirectory: state => {
    return state.currentDirectory;
  },

  // Meta
  meta: state => {
    return state.meta;
  },

  // Models
  storeModels: state => {
    return state.models;
  },

  modelSettings: state => {
    return state.modelSettings;
  },

  // Mothership API
  mothershipUrl: state => {
    if (state.mothership) {
      return state.mothership['url'];
    }
    return null;
  },
  mothershipApiKey: state => {
    if (state.mothership) {
      return state.mothership['api-key'];
    }
    return null;
  },

  changes: state => {
    return state.changes;
  },

  // Pages
  pages: state => {
    return state.pages;
  },

  pagesList: state => {
    return state.pagesList;
  },

  page: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.pageId);
    return state.pages.data.find(page => page.id === id);
  },

  currentPage: state => {
    return state.currentPage;
  },

  // Sites
  sites: state => {
    return state.sites;
  },

  site: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.siteId);
    return getters.siteById(id);
  },

  siteById: state => id => {
    if (state.sites.data) {
      return state.sites.data.find(site => site.id === id);
    }
  },

  theme: (state, getters, rootState) => {
    // chartColor1: {color: 'rgba(54, 162, 235, 1)'},
    // chartColor2: {color: 'rgba(75, 192, 192, 1)'},
    // chartColor3: {color: 'rgba(255, 206, 86, 1)'},
    // chartColor4: {color: 'rgba(255,99,132,1)'},
    // chartColor5: {color: 'rgba(153, 102, 255, 1)'},
    // chartColor6: {color: 'rgba(255, 159, 64, 1)'}

    let defaultColors = {
      // Used by the admin panels
      panel: {
        background: `radial-gradient(ellipse at top, #2C3858 , #182039)`,
        color: '#cdc9f1',
        secondaryColor: '#979797'
      },
      panelCard: {
        background: `#12182d`,
        color: '#eee'
      },
      panelSidebar: {
        background: '#182039',
        color: '#eee',
        secondaryColor: 'rgb(101, 139, 239)',
        borderColor: tinycolor('#182039')
          .lighten(10)
          .toString()
      },
      panelIcons: {
        color: '#658BEF'
      },
      actionButton: {
        color: '#ffffff',
        background: '#EB8F89'
      },
      actionButtonGhost: {
        color: '#EB8F89',
        borderColor: '#EB8F89',
        borderWidth: '2px'
      },
      secondaryButton: {
        color: '#ffffff',
        background: '#EB8F89'
      },
      secondaryButtonGhost: {
        color: '#EB8F89',
        borderColor: '#EB8F89',
        borderWidth: '2px'
      },
      help: {
        color: '#EB8F89',
        borderColor: '#EB8F89',
        backgroundColor: '#ffe5e4'
      },
      chartColor1: { color: 'rgba(54, 162, 235, 1)' },
      chartColor2: { color: 'rgba(75, 192, 192, 1)' },
      chartColor3: { color: 'rgba(255, 206, 86, 1)' },
      chartColor4: { color: 'rgba(255, 99, 132, 1)' },
      chartColor5: { color: 'rgba(153, 102, 255, 1)' },
      chartColor6: { color: 'rgba(255, 159, 64, 1)' }
    };

    let colors = defaultColors;

    if (state.currentPage) {
      let site = getters.siteById(state.currentPage.site_id);

      // The last part of this if is checking for new initial color scheme to accommodate
      // older instances of alpha Devise 2
      if (site && site.settings && site.settings.colors) {
        let sc = site.settings.colors;

        if (sc.panelTop && sc.panelBottom) {
          colors.panel = {
            background: `radial-gradient(ellipse at top, ${sc.panelTop.color}, ${
              sc.panelBottom.color
            })`,
            color: sc.panelText.color,
            secondaryColor: '#979797'
          };
        }

        if (sc.panelpanelSidebarBackgroundTop && sc.panelSidebarText) {
          colors.panelCard = {
            background: sc.panelSidebarBackground.color,
            color: sc.panelSidebarText.color
          };
        }

        if (
          sc.penalSidebarBackground &&
          sc.panelSidebarText &&
          sc.panelSidebarAction &&
          sc.panelSidebarBackground
        ) {
          colors.panelSidebar = {
            background: sc.panelSidebarBackground.color,
            color: sc.panelSidebarText.color,
            secondaryColor: sc.panelSidebarAction.color,
            borderColor: tinycolor(sc.panelSidebarBackground.color)
              .lighten(10)
              .toString()
          };
        }

        if (sc.panelAction) {
          colors.panelIcons = {
            color: sc.panelAction.color
          };
        }

        if (sc.buttonsActionBackground && sc.buttonsActionText) {
          colors.actionButton = {
            background: sc.buttonsActionBackground.color,
            color: sc.buttonsActionText.color
          };
        }

        if (sc.buttonsActionBackground) {
          colors.actionButtonGhost = {
            border: `2px solid ${sc.buttonsActionBackground.color}`,
            color: sc.buttonsActionBackground.color
          };
        }

        if (sc.buttonsSecondaryBackground && sc.buttonsSecondaryText) {
          colors.secondaryButton = {
            background: sc.buttonsSecondaryBackground.color,
            color: sc.buttonsSecondaryText.color
          };
        }

        if (sc.buttonsSecondaryBackground) {
          colors.secondaryButtonGhost = {
            border: `2px solid ${sc.buttonsSecondaryBackground.color}`,
            color: sc.buttonsSecondaryBackground.color
          };
        }

        if (sc.helpBackground && sc.helpText) {
          colors.help = {
            background: sc.helpBackground.color,
            border: `1px solid ${sc.helpBackground.color}`,
            color: sc.helpText.color
          };
        }

        if (
          sc.chartColor1 &&
          sc.chartColor2 &&
          sc.chartColor3 &&
          sc.chartColor4 &&
          sc.chartColor5 &&
          sc.chartColor6
        )
          colors.chartColor1 = { color: sc.chartColor1.color };
        colors.chartColor2 = { color: sc.chartColor2.color };
        colors.chartColor3 = { color: sc.chartColor3.color };
        colors.chartColor4 = { color: sc.chartColor4.color };
        colors.chartColor5 = { color: sc.chartColor5.color };
        colors.chartColor6 = { color: sc.chartColor6.color };
      }
    }

    colors = Object.assign({}, defaultColors, colors);

    return colors;
  },

  // Slices
  slicesList: state => {
    return state.slices;
  },

  slicesDirectories: state => {
    return state.slicesDirectories;
  },

  // Templates
  templates: state => {
    return state.templates;
  },

  template: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.templateId);
    return state.templates.data.find(template => template.id === id);
  },

  // Redirects
  redirects: state => {
    return state.redirects;
  },

  redirect: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.redirectId);
    return state.redirects.data.find(redirect => redirect.id === id);
  },

  currentRedirect: state => {
    return deviseSettings.$redirect;
  },

  // Users
  users: state => {
    return state.users;
  },

  user: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.userId);
    return state.users.data.find(user => user.id === id);
  },

  currentUser: state => {
    return deviseSettings.$user;
  }
};

export default getters;
