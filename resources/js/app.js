/**
 * Import of Vue and Vue-Plugins
 */
import Vue from 'vue';
import VeeValidate from 'vee-validate';
import router from './router';
import store from './store';

Vue.use(VeeValidate);

/**
 * Import of main components
 */
import WorkshopGui from './components/WorkshopGui';

const app = new Vue({
  el: '#workshop',
  components: {
    WorkshopGui,
  },
  router,
  store
});