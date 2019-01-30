<template>

  <div class="view--inner" v-if="$store.getters.isDevMode">

    <div class="dashboard-container welcome">

      <h2 class="headline--one">
        Welcome!
        <small>Let's build something awesome!</small>
        <!--<span class="dashboard-info" title="Current branch: Hajpoei">-->
          <!--<i class="fas fa-code-branch"></i> - -->
          <!--Hajopei-->
        <!--</span>-->
      </h2>

    </div>

    <!-- List with patterns to review -->
    <status-list
            :container-class="'toReview'"
            :patterns="statusList['review']"
            :loading-status="loadingStatusList">
      <h3>To Review:</h3>
    </status-list>

    <!-- List with rejected patterns -->
    <status-list
            :container-class="'rejected'"
            :patterns="statusList['rejected']"
            :loading-status="loadingStatusList">
      <h3>Rejected <i class="fas fa-exclamation-triangle"></i> :</h3>
    </status-list>

    <shortcuts v-if="showKeyMap"
               :globalKeymap="globalShortcuts">
    </shortcuts>

  </div>

</template>

<script>

  import {API} from '../restClient';
  import LOG from '../logger';
  import {globalShortcuts, showKeyMap} from '../shortcuts';
  import Shortcuts from './Shortcuts';
  import StatusList from "./StatusList";

  export default {
    name: "Dashboard",

    components: {
      StatusList,
      Shortcuts
    },

    data() {
      return {
        loadingStatusList: false,
        statusList: {
          todo: [],
          review: [],
          rejected: [],
          done: []
        },
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
          const response = await API.get('status-list');
          this.statusList = response.data.data;
        } catch (e) {
          LOG.error(e);
        } finally {
          this.loadingStatusList = false;
        }
      }
    },

    mounted() {
      this.fetchStatusList();
    }
  }
</script>