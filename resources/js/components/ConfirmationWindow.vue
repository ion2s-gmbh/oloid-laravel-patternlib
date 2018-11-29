<template>

  <div class="popUp popUp--confirmation">

    <div class="popUp-inner a-dropIn">

      <p><slot></slot></p>

      <div class="popUp-controls">
        
        <button class="btn btn--sm btn--secondary" @click="confirmNo">
          <span>no</span>
        </button>

        <button class="btn btn--sm btn--primary" @click="confirmYes">
          <span>yes</span>
        </button>

      </div>

    </div>

    <div class="darken a-dropIn"></div>

  </div>

</template>

<script>
  export default {
    name: "ConfirmationWindow",

    methods: {
      confirmYes: function () {
        this.$emit('confirm-yes')
      },

      confirmNo: function () {
        this.$emit('confirm-no')
      }
    }
  }
</script>