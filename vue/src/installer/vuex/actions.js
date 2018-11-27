const actions = {
  // Pages
  createPage(context, page) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + "pages/", page)
        .then(function(response) {
          devise.$bus.$emit("showMessage", {
            title: "Success!",
            message: page.title + " has been created."
          });
          context.commit("createPage", response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit("showError", error);
        });
    }).catch(function(error) {
      devise.$bus.$emit("showError", error);
    });
  },

  // Sites
  createSite(context, site) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + "sites/", site)
        .then(function(response) {
          devise.$bus.$emit("showMessage", {
            title: "Success!",
            message: site.name + " has been created."
          });
          context.commit("createSite", response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit("showError", error);
        });
    }).catch(function(error) {
      devise.$bus.$emit("showError", error);
    });
  },
  // Users
  createUser(context, user) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + "users/", user)
        .then(function(response) {
          devise.$bus.$emit("showMessage", {
            title: "Success!",
            message: user.name + " has been created."
          });
          context.commit("createUser", response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit("showError", error);
        });
    }).catch(function(error) {
      devise.$bus.$emit("showError", error);
    });
  }
};

export default actions;
