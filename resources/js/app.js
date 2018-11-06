import Vue from 'vue';
import router from './router';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Workshop from './components/Workshop';

const app = new Vue({
  el: '#workshop',
  components: {
    Workshop,
  },
  router
});