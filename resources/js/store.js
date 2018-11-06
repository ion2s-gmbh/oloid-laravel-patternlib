import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    appInfo: {
      appName: 'test'
    },
    devMode: true
  },
  mutations: {
    appInfo (state, info) {
      state.appInfo = info.data;
    }
  }
});