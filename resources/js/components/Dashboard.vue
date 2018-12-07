<template>

  <div class="dashboard" v-if="$store.state.config.devMode">

    <div class="u-center">

      <h2 class="headline--one">
        Welcome!
        <small>Start building something awesome!</small>
      </h2> 

      <!--<router-link to="/preview/atoms.text.headline1">-->
        <!--<button class="btn btn&#45;&#45;secondary">        -->
          <!--<span>-->
            <!--Preview Pattern-->
          <!--</span>-->
        <!--</button>-->
      <!--</router-link>-->

      <router-link :to="{ name: 'create' }">
        <button class="btn btn--primary btn--cta">
          <span>
            New Pattern
          </span>
        </button>
      </router-link>    
      </div>

    <example-component></example-component>

  </div>

</template>

<script>

  import ExampleComponent from './ExampleComponent.vue';

  export default {
    name: "Dashboard",
    components: {
      ExampleComponent
    }
  }
</script>