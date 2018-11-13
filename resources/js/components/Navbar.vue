<template>

  <section class="project">

    
    <div class="project-info">{{ $store.state.appInfo.appName }}</div>


    <nav class="project-navigation">

      <!-- <a class="navbar-brand" href="/">{{ $store.state.appInfo.appName }}</a> -->

      <!-- <router-link :to="{ name: 'dashboard' }" class="navbar-brand">Workshop</router-link> -->

      <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
              aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> -->

      <div class="collapse navbar-collapse" id="navbarNavDropdown">

        
        
        <router-link :to="{ name: 'create' }">
          <button class="btn btn--create">
            <i class="fas fa-plus-square"></i>
          </button>
        </router-link>

      </div>

    </nav>
    
  </section>

</template>

<script>
  export default {
    name: "Navbar"
  }
</script>