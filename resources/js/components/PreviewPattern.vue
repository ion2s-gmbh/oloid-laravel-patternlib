<template>

  <div class="view--inner">

    <div class="code">

      <div class="code-el">

        <div class="code-header">

          <span v-if="!isToggled" class="code-type a-fadeIn">HTML</span>

          <span v-if="isToggled" class="code-type a-fadeIn">Blade</span>

          <label class="toggle-wrap">

            <input type="checkbox" class="toggle" v-model="isToggled"/>

            <div></div>

            <span>Show Blade</span>

          </label>

        </div>

        <div class="code-tabs">

          <div class="tab a-fadeIn" role="tabpanel" aria-labelledby="markup-view" v-if="isToggled" >

            <pre><code class="language-html">{{ pattern.template }}</code></pre>

          </div>

          <div class="tab a-fadeIn" id="html-view" role="tabpanel" aria-labelledby="html-view" v-if="!isToggled" >

            <pre><code class="language-html">{{ pattern.html }}</code></pre>

          </div>

        </div>

      </div>

      <div class="code-el">

        <div class="code-header">

          <span>CSS/SCSS</span>

        </div>

        <div class="code-tabs">

          <div class="tab" id="markup-view" role="tabpanel" aria-labelledby="markup-view">

            <pre><code>{{ pattern.sass }}</code></pre>

          </div>

        </div>

      </div>

    </div>

    <div class="preview">

      <div class="preview-infos">

        {{ pattern.name }}

        <status-bar
                @update-status="updateStatus"
                :status="pattern.status">
        </status-bar>

      </div>

      <div class="preview-inner">

        <iframe height="1500" width="1100"
                frameBorder="0"
                :src="`workshop/preview/${pattern.name}`"></iframe>


      </div>

    </div>

    <div class="footer">

      <router-link :to="{ name: 'create' }">

        <button class="btn btn--primary btn--sm">

          <span>

            New Pattern

          </span>

        </button>

      </router-link>

      <button class="btn btn--secondary btn--sm" @click="confirmDelete">

        <span>
          <i class="fas fa-trash-alt"></i>
          Delete
        </span>

      </button>

      <router-link :to="{ name: 'update' }">

        <button class="btn btn--primary btn--sm">

          <span>
            <i class="fas fa-pen"></i>
            Edit
          </span>

        </button>

      </router-link>

    </div>
    <confirmation-window
            v-if="showDeleteConfirm"
            @confirm-yes="deletePattern(pattern.name)"
            @confirm-no="showDeleteConfirm = false"
            :context="pattern">
    </confirmation-window>
  </div>

</template>

<script>
  import {API} from '../httpClient';
  import LOG from '../logger';
  import StatusBar from './StatusBar';
  import ConfirmationWindow from "./ConfirmationWindow";

  export default {
    name: "PreviewPattern",
    data() {
      return {
        pattern: {
          name: 'undefined'
        },
        loading: false,
        isToggled: false,
        showDeleteConfirm: false
      }
    },

    components: {
      ConfirmationWindow,
      StatusBar
    },

    watch: {
      '$route': 'fetchPattern',
    },

    methods: {

      /**
       * Fetch the Pattern's data from the API.
       */
      fetchPattern: async function () {
        // set to true, if we have to show a loading spinner
        this.loading = true;
        try {
          let response = await API.get(this.$route.params.pattern);
          this.pattern = response.data.data;
          this.loading = false;
        } catch (e) {
          LOG.error(e);
        }
      },

      /**
       * Update status of the Pattern.
       */
      updateStatus: async function (status) {
        try {
          let response = await API.put(`pattern/status/${this.pattern.name}`, {
            status
          });
          this.pattern.status = status;
        } catch (e) {
          LOG.error(e);
        }
      },

      confirmDelete: function () {
        this.showDeleteConfirm = true;
      },

      /**
       * Delete the pattern
       * @param pattern
       */
      deletePattern: async function (pattern) {
        try {
          let response = await API.delete(pattern);
          this.$store.commit('reloadNavi', true);
          this.$router.push('/');
        } catch (e) {
          LOG.error(e);
        }
      }
    },

    /**
     * Load all Pattern information from API.
     */
    created() {
      this.fetchPattern();
    }
  }
</script>