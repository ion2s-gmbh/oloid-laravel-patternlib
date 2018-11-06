import Vue from 'vue';
import Vuex from 'vuex';
import config from './config';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    config,
    appInfo: {
      appName: 'test'
    }
  },
  mutations: {
    appInfo (state, info) {
      state.appInfo = info.data;
    }
  }
});