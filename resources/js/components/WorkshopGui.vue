<template>
  
  <main class="window">
    
    <!-- NAVIGATION -->
    <navbar class="header"></navbar>

    <!-- MAIN VIEW SECTION -->
    <section class="view" @click="resetMenu()">

      <router-view></router-view>

    </section>

    <button class="toggle--more has-tooltip shortcuts" v-tooltip.top-center="'Show keyboard shortcuts'">
      <i class="fas fa-keyboard"
       @click="toggleKeyMap">
      </i>
    </button>

  </main>

</template>

<script>
  import Navbar from './Navbar';
  import {keys} from '../shortcuts';

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
       * Toogle the key map.
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

        // console.error(event.key);
        // console.error(event.keyCode);

        const target = event.target || event.srcElement;
        const key = event.key;

        /*
         * Trigger the creation of a new Pattern by 'c'
         */
        if ( target.tagName !== "TEXTAREA" && target.tagName !== "INPUT" ) {
          if (key === keys.CREATE) {
            this.createPattern();
          }

          /*
           * Trigger the explanation of the shortcuts
           */
          if (key === keys.HELP) {
            this.$store.dispatch('openKeyMap');
          }

          if (key === keys.CLOSE) {
            this.$store.dispatch('closeKeyMap');
          }
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
