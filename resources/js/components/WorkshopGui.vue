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

        console.error(event.key);
        console.error(event.keyCode);
        console.error(event.keyIdentifier);

        const C = 'c';
        const QUESTION_MARK = '?';
        const target = event.target || event.srcElement;
        const key = event.key;

        if (key === undefined) {
          event.preventDefault();
          event.stopPropagation();
          console.error(event);
        }

        /*
         * Trigger the creation of a new Pattern by 'c'
         */
        if ( target.tagName !== "TEXTAREA" && target.tagName !== "INPUT" ) {
          if (key === C) {
            this.createPattern();
          }

          /*
           * Trigger the explanation of the shortcuts
           */
          if (event.shiftKey && key === QUESTION_MARK) {
            this.toggleKeyMap();
          }
          event.stopPropagation();
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
