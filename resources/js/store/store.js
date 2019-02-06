import Vue from 'vue';
import Vuex from 'vuex';
import config from '../config';
import getters from './getters';
import mutations from './mutations';
import actions from './actions';

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
    showResources: false,
    resources: {
      head: '',
      body: ''
    }
  },

  getters,
  mutations,
  actions
});