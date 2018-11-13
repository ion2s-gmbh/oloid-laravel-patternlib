<template>

  <div class="row">
    <div class="col-sm-4">
      <div class="py-1">
        <router-link :to="{ name: 'update', params: { pattern: pattern.name }}">
          <button class="btn btn-primary">
            <i class="fas fa-pen"></i>
            UPDATE
          </button>
        </router-link>
        <button class="btn btn-danger" @click="deletePattern(pattern.name)">
          <i class="fas fa-trash-alt"></i>
          DELETE
        </button>
      </div>
      <h2>{{ pattern.name }}
        <span v-if="pattern.status === 'TODO'" class="badge badge-danger">TODO</span>
        <span v-if="pattern.status === 'REVIEW'" class="badge badge-warning">REVIEW</span>
        <span v-if="pattern.status === 'DONE'" class="badge badge-success">DONE</span>
      </h2>
      <h2>Description</h2>
      <div class="code">
        <pre><code class="language-markdown">{{ pattern.description }}</code></pre>
      </div>
      <br>
      <h2>Usage
        <button id="copy" class="btn btn-secondary" data-clipboard-target="#pattern">
          <i class="far fa-clipboard"></i>
        </button>
      </h2>
      <div class="code">
        <pre><code id="pattern">@{{ pattern.type }}('{{ pattern.usage }}', [])</code></pre>
      </div>
      <br>
      <h2>Markup/HTML</h2>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#markup-view" role="tab"
             aria-controls="markup-view" aria-selected="true">Markup</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#html-view" role="tab"
             aria-controls="html-view" aria-selected="false">HTML</a>
        </li>
      </ul>
      <div class="code">
        <div class="tab-content">
          <div class="tab-pane fade show active" id="markup-view" role="tabpanel"
               aria-labelledby="markup-view">
            <pre><code class="language-html">{{ pattern.template }}</code></pre>
          </div>
          <div class="tab-pane fade" id="html-view" role="tabpanel" aria-labelledby="html-view">
            <pre><code class="language-html">{{ pattern.html }}</code></pre>
          </div>
        </div>
      </div>
      <br>
      <h2>SASS/CSS</h2>
      <div class="code">
        <pre><code class="language-css">{{ pattern.sass }}</code></pre>
      </div>
    </div>
    <div class="col-sm-8">
      <h2>Preview</h2>
      <div class="code">
        <div class="card-body">
          <iframe height="1500" width="1100"
                  frameBorder="0"
                  :src="`workshop/preview/${pattern.name}`"></iframe>
        </div>
      </div>
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