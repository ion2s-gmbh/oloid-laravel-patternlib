<template>
  <router-link :to="{ name: 'preview', params: { patternName: `${item.path}` } }">
    {{ item.name }}
  </router-link>
</template>

<script>
  export default {
    name: "NavbarLink",

    props: {
      item: Object
    }
  }
</script>