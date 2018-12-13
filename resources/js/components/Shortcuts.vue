<template>
  <div class="popUp popUp--shortcuts" @click="close">

    <div class="popUp-inner a-dropIn">
      <template v-if="globalKeymap">
        <h3>Global shortcuts:</h3>
        <ul>
          <li v-for="key in globalKeymap">{{ key.stroke }} - {{ key.description}}</li>
        </ul>
      </template>

      <template v-if="pageKeymap">
        <h3>Shortcuts on this page:</h3>
        <ul>
          <li v-for="key in pageKeymap">{{ key.stroke }} - {{ key.description}}</li>
        </ul>
      </template>

    </div>

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