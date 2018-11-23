<template>
  
  <main class="window">
    
    <!-- NAVIGATION -->
    <navbar class="header"></navbar>
    
    <!-- MAIN VIEW SECTION -->
    <section class="view" @click="resetMenu()">

      <router-view></router-view>

    </section>    

  </main>

</template>

<script>
  import Navbar from './Navbar';
  import {API} from '../httpClient';
  import LOG from '../logger';

  export default {
    name: "WorkshopGui",
    components: {
      Navbar
    },

    methods: {

      /**
       * Reset the main menu state.
       */
      resetMenu: function () {
        this.$store.commit('resetMainMenu');
      }
    },

    /**
     * Fetch application information before creating.
     * @returns {Promise<void>}
     */
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
