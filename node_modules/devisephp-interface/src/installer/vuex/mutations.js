export default {
  // Checklist
  updateChecklist(state, checklist) {
    state.checklist = Object.assign({}, state.checklist, checklist);
  },

  // Languages
  setLanguages(state, payload) {
    state.languages = payload;
  }
};
