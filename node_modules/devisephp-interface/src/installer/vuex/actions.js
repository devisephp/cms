const actions = {
  // Checklist
  refreshChecklist(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'install-checklist/')
        .then(function(response) {
          context.commit('updateChecklist', response.data);
          resolve(response);
        })
        .catch(function(error) {
          console.log('error in retrieving checklist');
        });
    }).catch(function(error) {
      console.log('error in retrieving checklist');
    });
  },

  // Install Complete
  completeInstall(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'install-complete/')
        .then(function(response) {
          resolve(response);
        })
        .catch(function(error) {
          console.log(
            'error in completing the install. You can add DVS_MODE=active to your .env to manually complete'
          );
        });
    }).catch(function(error) {
      console.log(
        'error in completing the install.  You can add DVS_MODE=active to your .env to manually complete'
      );
    });
  },

  // Languages
  getLanguages(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'languages/')
        .then(function(response) {
          context.commit('setLanguages', response.data);
          resolve(response);
        })
        .catch(function(error) {
          window.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      window.$bus.$emit('showError', error);
    });
  },

  createLanguage(context, language) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'languages/', language)
        .then(function(response) {
          window.$bus.$emit('showMessage', {
            content: 'Your new language has been added.'
          });
          context.commit('createLanguage', response.data);
          resolve(response);
        })
        .catch(function(error) {
          window.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      window.$bus.$emit('showError', error);
    });
  },

  // Pages
  createPage(context, page) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'pages/', page)
        .then(function(response) {
          window.$bus.$emit('showMessage', {
            content: page.title + ' has been created.'
          });
          context.commit('createPage', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          window.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      window.$bus.$emit('showError', error);
    });
  },

  // Sites
  createSite(context, site) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'sites/', site)
        .then(function(response) {
          window.$bus.$emit('showMessage', {
            content: site.name + ' has been created.'
          });
          context.commit('createSite', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          window.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      window.$bus.$emit('showError', error);
    });
  },

  // Users
  createUser(context, user) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'users/', user)
        .then(function(response) {
          window.$bus.$emit('showMessage', {
            content: '<strong>Step complete!</strong> ' + user.name + ' has been created.'
          });
          context.commit('createUser', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          window.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      window.$bus.$emit('showError', error);
    });
  }
};

export default actions;
