import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/Dashboard';
import CreatePattern from './components/CreatePattern';
import UpdatePattern from './components/UpdatePattern';
import PreviewPattern from './components/PreviewPattern';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'hash',
  routes: [
    { path: '/', component: Dashboard, name: 'dashboard' },
    { path: '/create', component: CreatePattern, name: 'create' },
    { path: '/update', component: UpdatePattern, name: 'update' },
    { path: '/preview/:pattern', component: PreviewPattern, name: 'preview' }
  ]
});