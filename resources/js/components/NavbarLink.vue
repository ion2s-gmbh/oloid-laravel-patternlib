<template>
  <router-link :to="{ name: 'preview', params: { pattern: `${item.path}` } }">
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
    }
  }
</script>