<template>

  <div class="popUp popUp--settings" @click="close">

      <div class="popUp-inner a-dropIn">
      
        <p class="headline--two">Project settings</p>

        <div class="settings">
          
          <nav class="settings-nav">
            <ul>
              <li>CSS</li>
              <li>JS</li>
            </ul>
          </nav>
          
          <form action="" class="settings-content">

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

</template>

<script>
  export default {
    name: "Shortcuts",

    props: [
      'globalKeymap',
      'pageKeymap'
    ],

    methods: {

      /**
       * Close the shortcuts window.
       */
      close: function () {
        this.$store.commit('toggleKeyMap');
      }
    }
  }
</script>