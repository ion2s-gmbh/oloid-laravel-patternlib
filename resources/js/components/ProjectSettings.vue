<template>

  <div class="popUp popUp--settings">

      <div class="popUp-inner a-dropIn">
      
        <p class="headline--two">Project settings</p>

        <div class="settings">
          
          <tab-bar :selected="selected">
            
          </tab-bar>
          
          <form action="" class="settings-form">

            <div class="form-group">

              <label for="link">

                <span class="label-name">Link / Stylesheet</span>
                <span class="label-hint">Paste your CDN Links or paths into here.</span>
                <!-- <small class="error a-slideIn" v-if="errors.has('')">{{ errors.first('') }}</small> -->

              </label>

              <textarea id="name"
               class="form-control"
               type="text"
               name="name"
               autofocus></textarea>
              
            </div>

            <div class="form-group form-group--end">
              
              <button class="btn btn--secondary btn--cancel" @click="close">
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
      <button class="toggle--more close" @click="close">

        <i class="fas fa-times"></i>
        
        <span class="u-hide">Close</span>

      </button>


      <!-- DARKEN BACKGROUND -->
      <div class="darken a-dropIn"></div>

    </div> 

</template>

<script>

  import TabBar from "./TabBar";

  export default {
    name: "ProjectSettings",

    components: {
      TabBar
    },

    props: ['selected'],

    data() {
      return {
        cssOpen: false,
        jsOpen: true
      }
    },

    methods: {

      /**
       * Close the shortcuts window.
       */
      close: function () {
        this.$store.commit('toggleSettings');
      }
    }



  }
</script>