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

      createPattern: function () {
        this.$router.push({
          name: 'create'
        });
      },

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
    },

    mounted() {

      /*
       * Global shortcuts
       */
      window.addEventListener('keydown', (event) => {

        const C = 67;

        /*
         * Trigger the delete confirmation by Ctrl+DEL
         */
        if (event.ctrlKey && event.keyCode === C) {
          this.createPattern();
          event.preventDefault();
        }

      });
    }
  }
</script>
