<template>
  <div>
    <navbar></navbar>
    <div class="py-3">
      <router-link :to="{ name: 'create' }">
        <button class="btn btn-primary">
          <i class="fas fa-plus-square"></i>
          NEW PATTERN
        </button>
      </router-link>
      <router-link :to="{ name: 'update' }">
        <button class="btn btn-primary">
          <i class="fas fa-pen"></i>
          UPDATE PATTERN
        </button>
      </router-link>
      <router-link :to="{ name: 'preview' }">
        <button class="btn btn-primary">
          <i class="fas fa-eye"></i>
          PREVIEW PATTERN
        </button>
      </router-link>
      <hr>
      <div class="py-3">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  import Navbar from "./Navbar";

  export default {
    components: {Navbar},
    mounted() {
      console.log('Laratomics Workshop is open, come in and find out!')
    }
  }
</script>
