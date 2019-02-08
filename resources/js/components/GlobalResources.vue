<template>

  <div class="popUp popUp--settings">

      <div class="popUp-inner a-dropIn">
      
        <p class="headline--two">Project Resources</p>

        <div class="settings">
          
          <tab-bar :tabs="['for <head>', 'above </body>']"
                   :selected="0"
                   @changeTab="changeTab">
          </tab-bar>
          
          <form class="settings-form">

            <!-- FOR <HEAD>-->
            <div class="form-group a-slideIn" v-show="selectedTab === 'for <head>'">

              <label for="head-resources">

                <span class="label-name">Links / Stylesheets / Scripts</span>
                <span class="label-hint">Paste your CDN Links or paths into here.</span>
                <small class="error a-slideIn" v-if="errorOnSave">Sorry, we couldn't store the globla resources.</small>
                <small class="success a-slideIn" v-if="successOnSave">Global resources have been saved.</small>

              </label>

              <textarea id="head-resources"
                        class="form-control"
                        type="text"
                        name="head-resources"
                        autofocus
                        v-model="headResources"
                        @keydown.ctrl.enter.stop="save"
                        @keydown.esc.stop="close">
              </textarea>
              
            </div>

            <!-- ABOVE </BODY>-->
            <div class="form-group a-slideIn" v-show="selectedTab === 'above </body>'">

              <label for="body-resources">

                <span class="label-name">Scripts</span>
                <span class="label-hint">Paste your CDN Links or paths into here.</span>
                <small class="error a-slideIn" v-if="errorOnSave">Sorry, we couldn't store the global resources.</small>
                <small class="success a-slideIn" v-if="successOnSave">Global resources have been saved.</small>

              </label>

              <textarea id="body-resources"
                        class="form-control"
                        type="text"
                        name="body-resources"
                        autofocus
                        v-model="bodyResources"
                        @keydown.ctrl.83.prevent="save"
                        @keydown.esc="close">
              </textarea>

            </div>

            <div class="form-group form-group--end">
              
              <button type="button"
                      class="btn btn--cancel"
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
    name: "GlobalResources",

    components: {
      TabBar
    },

    data() {
      return {
        selectedTab: 'for <head>',
        errorOnSave: false,
        successOnSave: false
      }
    },

    computed: {

      headResources: {
        get () {
          return this.$store.getters.headResources;
        },
        set (headResources) {
          this.$store.commit('headResources', headResources);
        }
      },

      bodyResources: {
        get () {
          return this.$store.getters.bodyResources;
        },
        set (bodyResources) {
          this.$store.commit('bodyResources', bodyResources);
        }
      }
    },

    methods: {

      /**
       * Close the global resources window.
       */
      close: function () {
        this.$store.dispatch('fetchResources');
        this.$store.commit('toggleResources');
      },

      /**
       * Save the global resources.
       */
      save: async function () {
        const resources = {
          head: this.headResources,
          body: this.bodyResources
        };

        try {
          const response = await API.post('resources', resources);
          if (response.status !== 201) {
            this.errorOnSave = true;
          } else {
            this.successOnSave = true;
          }
        } catch (e) {
          this.errorOnSave = true;
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