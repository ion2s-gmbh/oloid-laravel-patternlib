<template>

  <div class="view--inner">

    <div class="code">

      <!-- <h2 class="headline--three">

        Headline_type_one
        {{ pattern.name }}
        <span v-if="pattern.status === 'TODO'" class="badge badge-danger">TODO</span>
        <span v-if="pattern.status === 'REVIEW'" class="badge badge-warning">REVIEW</span>
        <span v-if="pattern.status === 'DONE'" class="badge badge-success">DONE</span>

      </h2> -->

      <!-- <h2>Description</h2>

      <div class="code">
        <pre><code class="language-markdown">{{ pattern.description }}</code></pre>
      </div>

      <h2>Usage
        <button id="copy" class="btn btn-secondary" data-clipboard-target="#pattern">
          <i class="far fa-clipboard"></i>
        </button>
      </h2>  -->

      <!-- <div class="code">
        <pre><code class="language-html"
                   id="pattern">{{ '@' }}{{ pattern.type }}('{{ pattern.usage }}', [])</code></pre>
      </div> -->

      <div class="code-el">
        
        <h2>Markup/HTML</h2>                   

        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#markup-view" role="tab"
               aria-controls="markup-view" aria-selected="true">Markup</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#html-view" role="tab"
               aria-controls="html-view" aria-selected="false">HTML</a>
          </li>
        </ul> -->

        <div class="code-tabs">

          <div class="tab" id="markup-view" role="tabpanel"
               aria-labelledby="markup-view">
            <pre><code class="language-html">{{ pattern.template }}</code></pre>
          </div>

          <div class="tab" id="html-view" role="tabpanel" aria-labelledby="html-view">
            <pre><code class="language-html">{{ pattern.html }}</code></pre>
          </div>

        </div>

      </div>

      <div class="code-el">     

        <h2>SASS/CSS</h2>

        <div class="code">
          <pre><code class="language-css">{{ pattern.sass }}</code></pre>
        </div>

      </div>

    </div>

    <div class="preview">      
      
      <div class="">
        
        <!-- <iframe height="1500" width="1100"
                frameBorder="0"
                :src="'workshop/preview/atoms.text.headline1'"></iframe> -->

        <div style="background: transparent; height: 5000px; width: 5002px;"></div>

      </div>

    </div>

    <div class="footer">

      <router-link :to="{ name: 'update' }">
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

  </div>

</template>

<script>
  import {API} from '../httpClient';
  import LOG from '../logger';

  export default {
    name: "PreviewPattern",
    data() {
      return {
        pattern: {},
      }
    },

    methods: {

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
    async beforeCreate() {
      try {
        let response = await API.get(this.$route.params.pattern);
        this.pattern = response.data.data;
      } catch (e) {
        LOG.error(e);
      }
    }
  }
</script>