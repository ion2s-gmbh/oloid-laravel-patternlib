import Vue from 'vue';
import Vuex from 'vuex';
import config from './config';
import es6Promise from 'es6-promise';

/*
 * Polyfill for ie compatibility.
 */
es6Promise.polyfill();

Vue.use(Vuex);

export default new Vuex.Store({

  state: {
    config,
    appInfo: {},
    navi: {
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
      state.navi.activeMain = menu;
      state.navi.activeSub = '';
    },

    /**
     * Set the active sub menu item.
     * @param state
     * @param subMenu
     */
    toggleSubMenu(state, subMenu) {
      state.navi.activeSub = subMenu;
    },

    /**
     * Reset the active main menu item.
     * @param state
     */
    resetMainMenu(state) {
      state.navi.activeMain = '';
    },

    /**
     * Reset the active sub menu item.
     * @param state
     */
    resetSubMenu(state) {
      state.navi.activeSub = '';
    },

    /**
     * Start/stop a reload of the navi.
     * @param state
     * @param reload
     */
    reloadNavi(state, reload) {
      state.navi.reload = reload;
    }
  }
});