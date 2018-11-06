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
  export default {
    name: "WorkshopGui",
    components: {
      Navbar
    },
    async mounted() {
      try {
        let json = await API.get('info');
        this.$store.commit('appInfo', json.data);
      } catch (e) {
        console.error(e.status)
      }
    }
  }
</script>
