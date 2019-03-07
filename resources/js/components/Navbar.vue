<template>

  <section class="project">

    <div class="project-info">

      <h1 class="project-name">
        
        <a class="a" href="/" target="_blank">
          {{ $store.getters.appName }}
          <template v-if="$store.getters.currentBranch">
            |&nbsp;<i class="fas fa-code-branch"></i> -
            {{ $store.getters.currentBranch }}
          </template>
        </a>

      </h1>

      <div class="project-actions">

        <button class="toggle--more" v-tooltip.top-center="'Show project settings'" @click="toggleResources">

          <i class="fas fa-cog"></i>

          <span class="u-hide">Show project settings</span>

        </button>
        
      </div>      

    </div>

    <nav class="project-navigation">

      <router-link :to="{ name: 'dashboard' }" class="back a-slideIn" v-if="notDashboard">
        <i class="fas fa-arrow-circle-left"></i>
      </router-link>

      <ul class="patterns">

        <!-- render main navi items -->
        <navbar-main
                v-for="(menu, index) in navi"
                :menu="menu" :key="index">
        </navbar-main>
        
      </ul>

      <!-- CREATE BUTTON -->
      <router-link :to="{ name: 'create' }"  class="btn btn--create" v-tooltip.top-center="'Add new pattern to the project'">

        <i class="fas fa-plus"></i>

          <span>Create</span>

      </router-link>      

    </nav>    

    <global-resources v-if="showResources"></global-resources>

  </section>

</template>

<script>

  import NavbarMain from './NavbarMain';
  import {API} from '../restClient';
  import LOG from '../logger';
  import GlobalResources from './GlobalResources';
  import {keys} from '../shortcuts';

  export default {
    name: "Navbar",

    components: {
      NavbarMain,
      GlobalResources
    },

    data() {
      return {
        navi: [],
        globalKeyListener: null
      }      
    },

    computed: {

      /**
       * Value that indicates, if the dashboard is not shown.
       */
      notDashboard: function () {
        return this.$route.name !== 'dashboard';
      },

      /** 
       * Get the global state if the settings are visible
       */
      showResources: function () {
        return this.$store.getters.showResources;
      }
    },

    methods: {

      /**
       * Fetch the workshop navigation.
       * @returns {Promise<void>}
       */
      fetchNavi: async function () {
        try {
          let json = await API.get('navi');
          this.navi = json.data.data;
        } catch (e) {
          LOG.error(e);
        }
      },

      /**
       * Toggle the resources window.
       */
      toggleResources: function () {
        this.$store.commit('toggleResources');
      },

      /**
       * Reload the menu if requested.
       */
      reloadNavi: function () {
        if (this.$store.getters.reloadNavi) {
          this.fetchNavi();
          this.$store.commit('reloadNavi', false);
        }
      }
    },

    watch: {
      '$store.state.navi.reload': 'reloadNavi'
    },

    /**
     * Load the navigation from the API.
     */
    created() {
      this.fetchNavi();
    },

    /**
     * Mounted hook, adds a global event listener.
     */
    mounted() {

      /**
       * Global shortcuts
       */
      this.globalKeyListener = (event) => {

        const target = event.target || event.srcElement;
        const key = event.key;

        if ( target.tagName !== "TEXTAREA" && target.tagName !== "INPUT" ) {

          /*
           * Open the globale resources
           */
          if (key === keys.RESOURCES) {
            this.$store.dispatch('openGlobalResources');
          }

          /*
           * Close the globale resources
           */
          if (key === keys.CLOSE) {
            if (this.$store.getters.showResources === true) {
              event.stopPropagation();
              this.$store.dispatch('closeGloablResources');
            }
          }
        }
      };

      window.addEventListener('keydown', this.globalKeyListener, true);
    },

    /**
     * BeforeDestroy hook, removes the global event listener.
     */
    beforeDestroy() {
      window.removeEventListener('keydown', this.globalKeyListener, true);
    }
  }



</script>