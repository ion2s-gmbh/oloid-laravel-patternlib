<template>

  <div class="view--inner">

    <div class="code">

      <div class="code-el">

        <h2>

          <span>Markup</span> / <span>HTML</span>

        </h2>

        <div class="code-tabs">

          <div class="tab" id="markup-view" role="tabpanel" aria-labelledby="markup-view">

            <pre>
              <code class="language-html">{{ pattern.template }}</code>
            </pre>

          </div>

          <div class="tab" id="html-view" role="tabpanel" aria-labelledby="html-view">

            <pre>
              <code class="language-html">{{ pattern.html }}</code>
            </pre>

          </div>

        </div>

      </div>

      <div class="code-el">

        <h2>

          <span>SASS</span> / <span>CSS</span>

        </h2>

        <div class="code-tabs">

          <div class="tab" id="markup-view" role="tabpanel" aria-labelledby="markup-view">

              <pre><code class="language-css">.class {
                border: none;
              }
              </code></pre>

          </div>

        </div>

      </div>

    </div>

    <div class="preview">

      <div class="">

        <iframe height="1500" width="1100"
                frameBorder="0"
                :src="`workshop/preview/${pattern.name}`"></iframe>

        <div style="background: transparent; height: 5000px; width: 5002px;"></div>

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

      <button class="btn btn--secondary btn--sm" @click="deletePattern(pattern.name)">

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

  </div>

</template>

<script>
  import {API} from '../httpClient';
  import LOG from '../logger';

  export default {
    name: "PreviewPattern",
    data() {
      return {
        pattern: {
          'name': 'undefined'
        },
        loading: false,
      }
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
       * Delete the pattern
       * @param pattern
       */
      deletePattern: function (pattern) {
        alert('Deleting ' + pattern);
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