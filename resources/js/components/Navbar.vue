<template>

  <section class="project">

    <div class="project-info">

      <h1 class="project-name">
        
        <a class="a" href="/" target="_blank">
          {{ $store.getters.appName }}
        </a>
        
      </h1>

      <div class="project-actions">

        <button class="toggle--more" v-tooltip.top-center="'Show project settings'" @click="toggleSettings">

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

    <project-settings v-if="showSettings"></project-settings>

  </section>

</template>

<script>

  import NavbarMain from "./NavbarMain";
  import {API} from '../restClient';
  import LOG from '../logger';
  import ProjectSettings from './ProjectSettings';

  export default {
    name: "Navbar",

    components: {
      NavbarMain,
      ProjectSettings
    },

    data() {
      return {
        navi: [],
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
      showSettings: function () {
        return this.$store.getters.showSettings;
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

      toggleSettings: function () {
        this.$store.commit('toggleSettings');
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
    }
  }

</script>