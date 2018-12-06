/**
 * Import of Vue and Vue-Plugins
 */
import 'es6-promise/auto'
import Vue from 'vue';
import router from './router';
import store from './store';
import VeeValidate from 'vee-validate';
import './validationRules';
/**
 * Import of main components
 */
import WorkshopGui from './components/WorkshopGui';

Vue.use(VeeValidate);

const app = new Vue({
  el: '#workshop',
  components: {
    WorkshopGui,
  },
  router,
  store
});