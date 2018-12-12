<template>

  <div class="dashboard">

    <div class="u-center">

      <template v-if="!loading">

      <div class="a-dropIn">

          <h2 class="headline--one">
            Welcome!
            <small>Start building something awesome!</small>
          </h2>

          <router-link :to="{ name: 'create' }">
            <button class="btn btn--primary btn--cta">
              <span>
                New Pattern
              </span>
            </button>
          </router-link>

      </div>

      </template>

      <template v-else-if="loading">
        <img src="vendor/workshop/images/loader.gif">
      </template>
    </div>

  </div>

</template>

<script>

  import ExampleComponent from './ExampleComponent.vue';
  import {API} from '../httpClient';
  import LOG from '../logger';

  export default {
    name: "Dashboard",

    components: {
      ExampleComponent
    },

    data() {
      return {
        loading: true
      }
    },

    methods: {
      loadStatusList: async function () {
        try {
          let response = await API.get('status-list');
          this.loading = false;
        } catch (e) {
          LOG.error(e);
        }

        // setTimeout(() => {
        //   this.loading = false;
        // }, 3000);
      }
    },

    mounted() {
      this.loadStatusList();
    }
  }
</script>