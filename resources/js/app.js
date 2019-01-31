/**
 * Import of Vue and Vue-Plugins
 */
import 'es6-promise/auto'
import Vue from 'vue';
import router from './router';
import store from './store';
import VeeValidate from 'vee-validate';
import VTooltip from 'v-tooltip'
import './validationRules';
/**
 * Import of main components
 */
import WorkshopGui from './components/WorkshopGui';

Vue.use(VeeValidate);
Vue.use(VTooltip);

Vue.component('nav-tabs', {

    template: `
      <nav>
        
        <ul class="tabs-list">

          <li class="tab"
			  v-for="(tab, index) in tabs"
			  :class="{active: selected === tab }"
			  :key="index"
			  @click="selected = tab">

            <span>{{tab}}</span>

          </li>

        </ul

      </nav>`,

    data() {
      return {
        tabs: ['for <head>','above </body>', 'Other'],
        selected: 'for <head>'
      }
    }

  })

const app = new Vue({
  el: '#workshop',
  components: {
    WorkshopGui,
  },
  router,
  store
});