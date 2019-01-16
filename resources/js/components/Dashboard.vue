<template>

  <div class="view--inner" v-if="$store.getters.isDevMode">

    <div class="dashboard-container welcome">

      <h2 class="headline--one">
        Welcome!
        <small>Let's build something awesome!</small>
        <span class="dashboard-info" title="Current branch: Hajpoei">
          <i class="fas fa-code-branch"></i> -
          Hajopei
        </span>
      </h2>

    </div>

    <div class="dashboard-container toReview">

      <h3>To Review:</h3>

      <ul class="dashboard-list">

        <li class="dashboard-listItem">
          <a href="">organisms.forms.signUp</a>
        </li>

        <li class="dashboard-listItem">
          <a href="">atoms.buttons.cancel</a>
        </li>


      </ul>

    </div>

    <div class="dashboard-container rejected">

      <h3>Rejected <i class="fas fa-exclamation-triangle"></i> :</h3>

      <ul class="dashboard-list">

        <li class="dashboard-listItem">
          <a href="">pages.landingpage</a>
        </li>

        <li class="dashboard-listItem">
          <a href="">pages.profile</a>
        </li>

        <li class="dashboard-listItem">
          <a href="">pages.news</a>
        </li>

      </ul>

    </div>

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

  export default {
    name: "Dashboard",

    components: {
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
          const response = await API.get('status-list');
          this.statusList = response.data.data;
        } catch (e) {
          // TODO: give some user feedback
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