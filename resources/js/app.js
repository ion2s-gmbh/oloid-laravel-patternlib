console.log('workshop is open');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('workshop', require('./components/Workshop.vue'));

const app = new Vue({
  el: '#workshop'
});