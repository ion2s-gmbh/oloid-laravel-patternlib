<template>

  <div class="dashboard">

    <div class="u-center">

      <template v-if="!loadingStatusList">

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

      <template v-else-if="loadingStatusList">
        <img src="vendor/workshop/images/loader.gif">
      </template>
    </div>

    <shortcuts v-if="showKeyMap"
               :globalKeymap="globalShortcuts">
    </shortcuts>

  </div>

</template>

<script>

  import ExampleComponent from './ExampleComponent.vue';
  import {API} from '../restClient';
  import LOG from '../logger';
  import {globalShortcuts, showKeyMap} from '../shortcuts';
  import Shortcuts from './Shortcuts';

  export default {
    name: "Dashboard",

    components: {
      ExampleComponent,
      Shortcuts
    },

    data() {
      return {
        loadingStatusList: false,
        statusList: {},
        globalShortcuts
      }
    },

    computed: {
      /**
       * Imported computed properties
       */
      showKeyMap
    },

    methods: {

      /**
       * Fetch the status list.
       * @returns {Promise<void>}
       */
      fetchStatusList: async function () {
        try {
          this.loadingStatusList = true;
          let response = await API.get('status-list');
          this.statusList = response.data.data;
          this.loadingStatusList = false;
        } catch (e) {
          LOG.error(e);
        }
      }
    },

    mounted() {
      this.fetchStatusList();
    }
  }
</script>