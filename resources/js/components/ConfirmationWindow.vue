<template>

  <div class="popUp popUp--confirmation">

    <div class="popUp-inner a-dropIn">

      <p><slot></slot></p>

      <div class="popUp-controls">
        
        <button class="btn btn--sm btn--cancel" @click="confirmNo">
          <span>no</span>
        </button>

        <button class="btn btn--sm btn--save" @click="confirmYes">
          <span>yes</span>
        </button>

      </div>

    </div>

    <div class="darken a-dropIn"></div>

  </div>

</template>

<script>

  import {keys} from "../shortcuts";

  export default {
    name: "ConfirmationWindow",

    methods: {

      /**
       * Confirm YES action.
       */
      confirmYes: function () {
        this.$emit('confirm-yes')
      },

      /**
       * Confirm NO action
       */
      confirmNo: function () {
        this.$emit('confirm-no')
      }
    },

    mounted() {

      /*
       * Close the confirmation modal on ESC
       */
      window.addEventListener('keydown', (event) => {

        const key = event.key;

        if (key === keys.CLOSE) {
          this.confirmNo();
          event.stopPropagation();
        }
      });
    }
  }
</script>