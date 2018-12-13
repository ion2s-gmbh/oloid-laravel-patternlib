<template>
  
  <main class="window">
    
    <!-- NAVIGATION -->
    <navbar class="header"></navbar>

    <!-- MAIN VIEW SECTION -->
    <section class="view" @click="resetMenu()">

      <router-view></router-view>

    </section>

    <i class="fas fa-keyboard"
       @click="toggleKeyMap">
    </i>
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
       * Navigate to the create page.
       */
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
      },

      toggleKeyMap: function () {
        this.$store.commit('toggleKeyMap');
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

      /**
       * Global shortcuts
       */
      window.addEventListener('keydown', (event) => {

        const C = 67;
        const K = 75;

        /*
         * Trigger the creation of a new Pattern by Ctrl+C
         */
        if (event.ctrlKey && event.keyCode === C) {
          this.createPattern();
          event.preventDefault();
        }

        /*
         * Trigger the explanation of the shortcuts
         */
        if (event.ctrlKey && event.keyCode === K) {
          this.toggleKeyMap();
          event.preventDefault();
        }

      });
    }
  }
</script>
