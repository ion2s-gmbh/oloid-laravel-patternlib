<template>
  <div class="popUp popUp--shortcuts">

    <div class="popUp-inner a-dropIn">

      <template v-if="globalKeymap">

        <p class="headline--two">Global shortcuts:</p>

        <ul class="shortcuts-list">

          <li v-for="key in globalKeymap" class="shortcut">

            <span class="shortcut-keys">{{ key.stroke }}</span>
            <span class="shortcut-description">{{ key.description}}</span>

          </li>

        </ul>

      </template>

      <template v-if="pageKeymap">

        <p class="headline--two">Shortcuts on this page:</p>

        <ul class="shortcuts-list">

          <li v-for="key in pageKeymap" class="shortcut">

            <span class="shortcut-keys">{{ key.stroke }}</span>
            <span class="shortcut-description">{{ key.description}}</span>

          </li>

        </ul>

      </template>

    </div>

    <!-- ClOSE  -->
      <button class="toggle--more close" @click="close">

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