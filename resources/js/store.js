import Vue from 'vue';
import Vuex from 'vuex';
import config from './config';

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
    showKeyMap: false
  },

  getters: {

    /**
     * Return the devMode.
     * @param state
     * @returns {boolean}
     */
    isDevMode: state => {
      return state.config.devMode;
    },

    /**
     * Get the Laravel app name.
     * @param state
     * @returns {string}
     */
    appName: state => {
      return state.appInfo.appName;
    },

    /**
     * Determine if the navi should be reloaded.
     * @param state
     * @returns {boolean}
     */
    reloadNavi: state => {
      return state.navi.reload === true;
    },

    isActiveMainMenu: (state) => (menu) => {
      return state.navi.activeMain === menu;
    },

    /**
     * Determine if the given sub menu is currently active.
     * @param state
     * @returns {function(*=): boolean}
     */
    isActiveSubmenu: (state) => (menu) => {
      return state.navi.activeSub.includes(menu);
    },

    /**
     * Determine if the keyMap is shown.
     * @param state
     * @returns {getters.showKeyMap|(function(*))|boolean}
     */
    showKeyMap: state => {
      return state.showKeyMap;
    },
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
    resetMainMenu: state => {
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
    }
  },

  actions: {
    //
  }
});