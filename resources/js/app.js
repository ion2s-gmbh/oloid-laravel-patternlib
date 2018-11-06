/**
 * Import of Vue and Vue-Plugins
 */
import Vue from 'vue';
import router from './router';
import VeeValidate from 'vee-validate';

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
  router
});