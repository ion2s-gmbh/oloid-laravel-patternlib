import Vue from 'vue';
import Vuex from 'vuex';
import config from './config';

Vue.use(Vuex);

export default new Vuex.Store({

  state: {
    config,
    appInfo: {},
    menu: {
      activeMain: '',
      activeSub: '',
      reload: false
    }
  },

  mutations: {

    /**
     * Set basic application information retrieved from Laravel.
     * @param state
     * @param info
     */
    appInfo(state, info) {
      state.appInfo = info.data;
    },

    /**
     * Set the active main menu item.
     * @param state
     * @param menu
     */
    toggleMainMenu(state, menu) {
      state.menu.activeMain = menu;
      state.menu.activeSub = '';
    },

    /**
     * Set the active sub menu item.
     * @param state
     * @param subMenu
     */
    toggleSubMenu(state, subMenu) {
      state.menu.activeSub = subMenu;
    },

    /**
     * Reset the active main menu item.
     * @param state
     */
    resetMainMenu(state) {
      state.menu.activeMain = '';
    },

    /**
     * Reset the active sub menu item.
     * @param state
     */
    resetSubMenu(state) {
      state.menu.activeSub = '';
    },

    /**
     * Start/stop a reload of the menu.
     * @param state
     * @param reload
     */
    reloadMenu(state, reload) {
      state.menu.reload = reload;
    }
  }
});