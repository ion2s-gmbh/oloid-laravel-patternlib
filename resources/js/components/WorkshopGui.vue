<template>
  <div>
    <navbar></navbar>
    <div class="py-3">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Navbar from './Navbar';
  import { API } from '../httpClient';
  import LOG from '../logger';
  export default {
    name: "WorkshopGui",
    components: {
      Navbar
    },
    async beforeCreate() {
      try {
        let json = await API.get('info');
        this.$store.commit('appInfo', json.data);
      } catch (e) {
        LOG.error(e);
      }
    }
  }
</script>
