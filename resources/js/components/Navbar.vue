<template>

  <section class="project">


    <div class="project-info">

      <h1 class="project-name">{{ $store.getters.appName }}</h1>

      <div class="project-actions">

        <button class="toggle--more" v-tooltip.top-center="'Show project settings'">

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
      <router-link :to="{ name: 'create' }"  class="btn btn--primary btn--sm" v-tooltip.top-center="'Create new Pattern'">

        <span>

          <i class="fas fa-plus"></i>

          New Pattern

        </span>

      </router-link>      

    </nav>

    <div class="popUp popUp--settings" @click="close">

      <div class="popUp-inner a-dropIn">
      
        <p class="headline--two">Project settings</p>

        <div class="settings">
          
          <nav class="tabs tabs--settings">
            
            <ul class="tabs-list">

              <li class="tab"><span>CSS</span></li>              
              <li class="tab active"><span>JS</span></li>
              <li class="tab"><span>Privacy</span></li>

            </ul>

          </nav>
          
          <form action="" class="settings-form">

            <div class="form-group">

              <label for="link">

                <span class="label-name">Link / Stylesheet</span>
                <span class="label-hint">Paste your CDN Links or paths into here.</span>
                <!-- <small class="error a-slideIn" v-if="errors.has('name')">{{ errors.first('name') }}</small> -->

              </label>

              <textarea id="name"
               class="form-control"
               type="text"
               name="name"
               placeholder="e.g. <meta>, <link>, <script>"
               autofocus /></textarea>
              
            </div> 

            <div class="form-group form-group--end">
              
              <button class="btn btn--secondary btn--cancel">
                <span>Cancel</span>
              </button>

              <button class="btn btn--primary btn--save">
                <span>Save</span>
              </button>                   

            </div>                

          </form>

        </div>


      </div>


      <!-- END SETTINGS  -->
      <button class="toggle--more close">

        <i class="fas fa-times"></i>
        
        <span class="u-hide">Close</span>

      </button>

      <div class="darken a-dropIn"></div>

  </div>    

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