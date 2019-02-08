import {API} from "../restClient";
import LOG from "../logger";

export default {

  /**
   * Fetch the app information.
   * @param commit
   * @returns {Promise<void>}
   */
  fetchAppInfo: async ({commit}) => {
    try {
      let json = await API.get('info');
      commit('appInfo', json.data);
    } catch (e) {
      LOG.error(e);
    }
  },

  /**
   * Fetch the global resources from the API.
   * @returns {Promise<void>}
   */
  fetchResources: async function () {
    try {
      const response = await API.get('resources');
      this.commit('headResources', response.data.data.head);
      this.commit('bodyResources', response.data.data.body);
    } catch (e) {
      LOG.error(e);
    }
  },

  /**
   * Toggle/untoggle the given dropdown.
   * An other toggled dropdown will consequently be untoggled.
   * @param commit
   * @param state
   * @param dropdown
   */
  toggleDropdown: ({commit, state}, dropdown) => {
    if (state.activeDropdown !== dropdown) {
      commit('toggleDropdown', dropdown);
    } else {
      commit('resetDropdown');
    }
  },

  /**
   * Trigger reset of any active dropdown menu in the main window.
   * @param commit
   * @param state
   */
  resetDropdowns: ({commit, state}) => {
    if (state.activeDropdown !== '') {
      commit('resetDropdown');
    }
  },

  /**
   * Reset the menu (navi).
   * @param commit
   * @param state
   */
  resetMenu: ({commit, state}) => {
    if (state.navi.activeMain !== '') {
      commit('resetMenu');
    }
  },

  /**
   * Open/show the keymap.
   * @param commit
   * @param state
   */
  openKeyMap: ({commit, state}) => {
    if (state.showKeyMap === false) {
      commit('toggleKeyMap');
    }
  },

  /**
   * Close/hide the keymap.
   * @param commit
   * @param state
   */
  closeKeyMap: ({commit, state}) => {
    if (state.showKeyMap === true) {
      commit('toggleKeyMap');
    }
  },

  /**
   * Open the global resources.
   * @param commit
   * @param state
   */
  openGlobalResources: ({commit, state}) => {
    if (state.showResources === false) {
      commit('toggleResources');
    }
  },

  /**
   * Close the global resources.
   * @param commit
   * @param state
   */
  closeGloablResources: ({commit, state}) => {
    if (state.showResources === true) {
      commit('toggleResources');
    }
  },
}