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
      activeSub: ''
    }
  },

  mutations: {

    /*
    |--------------------------------------------------------------------------
    | appInfo
    |--------------------------------------------------------------------------
    | Set basic application information retrieved from Laravel.
    */
    appInfo (state, info) {
      state.appInfo = info.data;
    },

    toggleMainMenu (state, menu) {
      state.menu.activeMain = menu;
      state.menu.activeSub = '';
    },

    toggleSubMenu (state, subMenu) {
      state.menu.activeSub = subMenu;
    },

    resetMainMenu (state) {
      state.menu.activeMain = '';
    },

    resetSubMenu (state) {
      state.menu.activeSub = '';
    }
  }
});