<template>

  <section class="project">

    
    <div class="project-info">

      <h1 class="project-name">{{ $store.state.appInfo.appName }}</h1>
      
      <!-- <div class="project-updates">
        <button class="btn">
            <i class="fas fa-bell"></i>
          </button>
      </div> -->

    </div>


    <nav class="project-navigation">

      <!-- <ul class="patterns">
        <li>Link[##]</li>
        <li>Link[##]</li>
        <li>Link[##]</li>
        <li>Link[##]</li>
        <li>Link[##]</li>
      </ul> -->

      <!-- <router-link :to="{ name: 'create' }">
        
        <button class="btn btn--create">
          <i class="fas fa-plus-square"></i>
        </button>

      </router-link> -->

    </nav>
    
  </section>

</template>

<script>
  export default {
    name: "Navbar"
  }
</script>