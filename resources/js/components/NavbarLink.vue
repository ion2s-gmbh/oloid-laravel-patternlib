<template>
  <router-link :to="{ name: 'preview', params: { pattern: `${item.name}` } }">
    {{ item.name }}
  </router-link>
</template>

<script>
  export default {
    name: "NavbarLink",
    props: {
      parent: {
        type: String,
        default: ''
      },
      item: Object
    },

    mounted() {
      console.log(this.item);
    }
  }
</script>