<template>
  
  <main class="window">
    
    <!-- NAVIGATION -->
    <navbar class="header"></navbar>

    <!-- MAIN VIEW SECTION -->
    <section class="view" @click="resetMenu()">

      <router-view></router-view>

    </section>

    <button class="toggle--more has-tooltip shortcuts">
      <i class="fas fa-keyboard"
       @click="toggleKeyMap">
      </i>
    </button>

  </main>

</template>

<script>
  import Navbar from './Navbar';
  import {keyPressed} from "../helpers";

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
        this.$store.dispatch('resetMenu')
      },

      toggleKeyMap: function () {
        this.$store.commit('toggleKeyMap');
      }
    },

    /**
     * Fetch application information before creating.
     * @returns {Promise<void>}
     */
    beforeCreate() {
      this.$store.dispatch('fetchAppInfo')
    },

    mounted() {

      /**
       * Global shortcuts
       */
      window.addEventListener('keydown', (event) => {

        const C = 67;
        const K = 75;

        const key = keyPressed(event);

        /*
         * Trigger the creation of a new Pattern by Ctrl+C
         */
        if (event.ctrlKey && key === C) {
          this.createPattern();
          event.preventDefault();
        }

        /*
         * Trigger the explanation of the shortcuts
         */
        if (event.ctrlKey && key === K) {
          this.toggleKeyMap();
          event.preventDefault();
        }

      });
    }
  }
</script>
