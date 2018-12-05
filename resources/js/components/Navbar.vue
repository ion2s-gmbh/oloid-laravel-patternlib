<template>

  <section class="project">


    <div class="project-info">

      <h1 class="project-name">{{ $store.state.appInfo.appName }}</h1>

    </div>

    <nav class="project-navigation">

      <router-link :to="{ name: 'dashboard' }" class="back a-dropIn" v-if="notDashboard">
        <i class="fas fa-arrow-circle-left"></i>
      </router-link>

      <ul class="patterns">

        <!-- render main navi items -->
        <navbar-main
                v-for="(menu, index) in navi"
                :menu="menu" :key="index">
        </navbar-main>
        
      </ul>

      <router-link :to="{ name: 'create' }"  class="btn btn--primary btn--sm" title="Create new Pattern">

        <span>

          <i class="fas fa-plus"></i>

          Add Pattern

        </span>

      </router-link>

    </nav>

  </section>

</template>

<script>

  import NavbarMain from "./NavbarMain";
  import NavbarLink from "./NavbarLink";
  import NavbarGroup from "./NavbarGroup";
  import {API} from '../httpClient';
  import LOG from '../logger';

  export default {
    name: "Navbar",
    components: {
      NavbarMain,
      NavbarLink,
      NavbarGroup
    },

    data() {
      return {
        navi: []
      }
    },

    computed: {
      notDashboard: function () {
        return this.$route.name !== 'dashboard';
      }
    },

    watch: {
      '$store.state.navi.reload': 'reloadNavi'
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
        if (this.$store.state.navi.reload === true) {
          this.fetchNavi();
          this.$store.commit('reloadNavi', false);
        }
      }
    },

    /**
     * Load the navigation from the API.
     */
    created() {
      this.fetchNavi();
    }
  }

</script>