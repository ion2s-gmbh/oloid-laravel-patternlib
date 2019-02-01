<template>

  <div class="popUp popUp--settings">

      <div class="popUp-inner a-dropIn">
      
        <p class="headline--two">Project settings</p>

        <div class="settings">
          
          <tab-bar :tabs="['for <head>', 'above </body>']"
                   :selected="0"
                   @changeTab="changeTab">
          </tab-bar>
          
          <form class="settings-form">

            <!-- FOR <HEAD>-->
            <div class="form-group a-slideIn" v-show="selectedTab === 'for <head>'">

              <label for="head-dependencies">

                <span class="label-name">Links / Stylesheets / Scripts</span>
                <span class="label-hint">Paste your CDN Links or paths into here.</span>
                <!-- <small class="error a-slideIn" v-if="errors.has('')">{{ errors.first('') }}</small> -->

              </label>

              <textarea id="head-dependencies"
                        class="form-control"
                        type="text"
                        name="head-dependencies"
                        autofocus
                        v-model="headDependencies">
              </textarea>
              
            </div>

            <!-- ABOVE </BODY>-->
            <div class="form-group a-slideIn" v-show="selectedTab === 'above </body>'">

              <label for="body-dependencies">

                <span class="label-name">Scripts</span>
                <span class="label-hint">Paste your CDN Links or paths into here.</span>
                <!-- <small class="error a-slideIn" v-if="errors.has('')">{{ errors.first('') }}</small> -->

              </label>

              <textarea id="body-dependencies"
                        class="form-control"
                        type="text"
                        name="body-dependencies"
                        autofocus
                        v-model="bodyDependencies">
              </textarea>

            </div>

            <div class="form-group form-group--end">
              
              <button type="button"
                      class="btn btn--secondary btn--cancel"
                      @click.prevent="close">
                <span>Cancel</span>
              </button>

              <button type="button"
                      class="btn btn--primary btn--save"
                      @click.prevent="save">
                <span>Save</span>
              </button>                   

            </div>                

          </form>

        </div>


      </div>


      <!-- END SETTINGS  -->
      <button class="toggle--more close" @click="close">

        <i class="fas fa-times"></i>
        
        <span class="u-hide">Close</span>

      </button>


      <!-- DARKEN BACKGROUND -->
      <div class="darken a-dropIn"></div>

    </div> 

</template>

<script>

  import TabBar from './TabBar';
  import {API} from '../restClient';
  import LOG from '../logger';

  export default {
    name: "ProjectSettings",

    components: {
      TabBar
    },

    data() {
      return {
        selectedTab: 'for <head>',
      }
    },

    computed: {

      headDependencies: {
        get () {
          return this.$store.getters.headSettings;
        },
        set (headerSettings) {
          this.$store.commit('headerSettings', headerSettings);
        }
      },

      bodyDependencies: {
        get () {
          return this.$store.getters.bodySettigs;
        },
        set (bodySettings) {
          this.$store.commit('bodySettings', bodySettings);
        }
      }
    },

    methods: {

      /**
       * Close the global settings window.
       */
      close: function () {
        this.$store.dispatch('fetchDependencies');
        this.$store.commit('toggleSettings');
      },

      /**
       * Save the global settings.
       */
      save: async function () {
        const dependencies = {
          head: this.headDependencies,
          body: this.bodyDependencies
        };

        try {
          const response = await API.post('dependencies', dependencies);
        } catch (e) {
          this.$store.dispatch('fetchDependencies');
          LOG.error(e);
        }
      },

      /**
       * Change the selected tab.
       * @param tab
       */
      changeTab: function (tab) {
        this.selectedTab = tab;
      }
    }
  }
</script>