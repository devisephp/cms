export default {
  // Checklist
  updateChecklist(state, checklist) {
    state.checklist = Object.assign({}, state.checklist, checklist);
  }
};
