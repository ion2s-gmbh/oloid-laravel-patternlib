import Vue from 'vue';
import Vuex from 'vuex';
import config from './config';
import {API} from './restClient';
import LOG from './logger';

Vue.use(Vuex);

export default new Vuex.Store({

  strict: config.environment !== 'production',

  state: {
    config,
    appInfo: {},
    navi: {
      activeMain: '',
      activeSub: '',
      reload: false
    },
    showKeyMap: false,
    activeDropdown: '',
    showSettings: false
  },

  getters: {

    /**
     * Return the devMode.
     * @param state
     * @returns {boolean}
     */
    isDevMode: state => state.config.devMode,

    /**
     * Get the Laravel app name.
     * @param state
     * @returns {string}
     */
    appName: state => state.appInfo.appName,

    /**
     * Determine if the navi should be reloaded.
     * @param state
     * @returns {boolean}
     */
    reloadNavi: state => state.navi.reload === true,

    isActiveMainMenu: (state) => (menu) => state.navi.activeMain === menu,

    /**
     * Determine if the given sub menu is currently active.
     * @param state
     * @returns {function(*=): boolean}
     */
    isActiveSubmenu: (state) => (menu) => state.navi.activeSub.includes(menu),

    /**
     * Determine if the keyMap is shown.
     * @param state
     * @returns {getters.showKeyMap|(function(*))|boolean}
     */
    showKeyMap: state => state.showKeyMap,

    showSettings: state => state.showSettings,

    /**
     *
     * @param state
     * @returns {getters.activeDropdown|(function(*))|string|any}
     */
    activeDropdown: state => state.activeDropdown,
  },

  mutations: {

    /**
     * Set basic application information retrieved from Laravel.
     * @param state
     * @param info
     */
    appInfo: (state, info) => {
      state.appInfo = info.data;
    },

    /**
     * Set the active main menu item.
     * @param state
     * @param menu
     */
    toggleMainMenu: (state, menu) => {
      state.navi.activeMain = menu;
      state.navi.activeSub = '';
    },

    /**
     * Set the active sub menu item.
     * @param state
     * @param subMenu
     */
    toggleSubMenu: (state, subMenu) => {
      state.navi.activeSub = subMenu;
    },

    /**
     * Reset the active main menu item.
     * @param state
     */
    resetMenu: state => {
      state.navi.activeMain = '';
    },

    /**
     * Reset the active sub menu item.
     * @param state
     */
    resetSubMenu: state => {
      state.navi.activeSub = '';
    },

    /**
     * Start/stop a reload of the navi.
     * @param state
     * @param reload
     */
    reloadNavi: (state, reload) => {
      state.navi.reload = reload;
    },

    /**
     * Toggle the keymap.
     * @param state
     */
    toggleKeyMap: (state) => {
      state.showKeyMap = !state.showKeyMap;
    },

    /**
     * Toggle the project settings.
     * @param state
     */
    toggleSettings: (state) => {
      state.showSettings = !state.showSettings;
    },

    /**
     * Toogle a dropdown.
     * @param state
     * @param dropdown
     */
    toggleDropdown: (state, dropdown) => {
      state.activeDropdown = dropdown;
    },

    /**
     * Reset the activeDropdown.
     * @param state
     */
    resetDropdown: (state) => {
      state.activeDropdown = '';
    }
  },

  actions: {

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
    }
  }
});