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