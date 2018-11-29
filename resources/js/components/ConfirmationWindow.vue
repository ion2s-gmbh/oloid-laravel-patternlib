<template>
  <div>
    <h1>Delete Pattern</h1>
    <p>Do you realy want to delete '{{ context.name }}'?</p>
    <button @click="confirmYes">yes</button>
    <button @click="confirmNo">no</button>
  </div>
</template>

<script>
  export default {
    name: "ConfirmationWindow",
    props: [
      'context'
    ],

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