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

    data() {
      return {
        globalKeyListener: null
      }
    },

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

      /**
       * Toogle the key map overlay.
       */
      toggleKeyMap: function () {
        this.$store.commit('toggleKeyMap');
      }
    },

    /**
     * Fetch application information and global resources before creating.
     * @returns {Promise<void>}
     */
    beforeCreate() {
      this.$store.dispatch('fetchAppInfo');
      this.$store.dispatch('fetchResources');
    },

    /**
     * Mounted hook, adds a global event listener.
     */
    mounted() {

      /**
       * Global shortcuts
       */
      this.globalKeyListener = (event) => {

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

      };

      window.addEventListener('keydown', this.globalKeyListener);
    },

    /**
     * BeforeDestroy hook, removes the global event listener.
     */
    beforeDestroy() {
      window.removeEventListener('keydown', this.globalKeyListener);
    }
  }
</script>
