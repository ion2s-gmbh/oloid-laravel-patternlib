import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/Dashboard';
import CreatePattern from './components/CreatePattern';
import UpdatePattern from './components/UpdatePattern';
import PreviewPattern from './components/PreviewPattern';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'hash',
  routes: [
    {
      path: '/',
      component: Dashboard,
      name: 'dashboard'
    },
    {
      path: '/create',
      component: CreatePattern,
      name: 'create'
    },
    {
      path: '/rename/:patternName',
      component: UpdatePattern,
      name: 'rename',
      props: true,
    },
    {
      path: '/preview/:patternName',
      component: PreviewPattern,
      name: 'preview',
      props: true,
    }
  ]
});

export default router;