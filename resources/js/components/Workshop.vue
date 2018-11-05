<template>
  <div>
    <navbar></navbar>
    <div class="py-3">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Navbar from './Navbar';

  export default {
    components: {
      Navbar
    },
    mounted() {
      console.log('Laratomics Workshop is open, come in and find out!')
    }
  }
</script>
