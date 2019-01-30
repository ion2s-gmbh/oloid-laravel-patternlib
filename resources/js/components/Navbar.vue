<template>

  <section class="project">


    <div class="project-info">

      <a class="a" href="/" target="_blank"><h1 class="project-name">{{ $store.getters.appName }}</h1></a>

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

      <router-link :to="{ name: 'create' }"  class="btn btn--primary btn--sm" v-tooltip.top-center="'Create new Pattern'">

        <span>

          <i class="fas fa-plus"></i>

          New Pattern

        </span>

      </router-link>

    </nav>

  </section>

</template>

<script>

  import NavbarMain from "./NavbarMain";
  import {API} from '../restClient';
  import LOG from '../logger';

  export default {
    name: "Navbar",

    components: {
      NavbarMain
    },

    data() {
      return {
        navi: []
      }
    },

    computed: {

      /**
       * Value that indicates, if the dashboard is not shown.
       */
      notDashboard: function () {
        return this.$route.name !== 'dashboard';
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