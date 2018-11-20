<template>

  <div class="dashboard" v-if="$store.state.config.devMode">

    <div class="u-center">

      <h2 class="headline--one">
        Welcome!
        <small>This is our temporary dashboard!</small>
      </h2> 

      <router-link to="/preview/atoms.text.headline1">
        <button class="btn btn--secondary">        
          <span>
            Preview Pattern
          </span>
        </button>
      </router-link>

      <router-link :to="{ name: 'create' }">
        <button class="btn btn--primary btn--cta">
          <span>
            New Pattern
          </span>
        </button>
      </router-link>    
      </div>

  </div>

</template>

<script>
  export default {
    name: "Dashboard"
  }
</script>