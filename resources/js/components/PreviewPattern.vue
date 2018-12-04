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

      <div class="preview-infosWrap">

        <div class="preview-infos">

          {{ pattern.name }}

          <status-bar
                  @update-status="updateStatus"
                  :status="pattern.status">
          </status-bar>

          <button class="toggle--more" @click="showDescription = !showDescription" :class="{ active: showDescription }" title="Show Pattern description">

            <i class="fas fa-align-left"></i>

          </button>          

        </div>        

        <p class="preview-description a-dropIn" v-if="showDescription">
          {{ pattern.description }}
        </p>

        <div class="preview-optionsWrap">

          <!-- MENUE TOGGLE -->

          <button class="toggle--more" @click="showOptions = !showOptions" :class="{ active: showOptions }">
            
            <i class="fas fa-ellipsis-v"></i>
            
          </button>

          <!-- ACTUAL MENUE -->

          <div class="preview-options a-dropIn" v-if="showOptions">

            <ul>              

              <li>

                <router-link :to="{ name: 'update' }" class="preview-option">

                  <span>
                    Edit Pattern
                  </span>

                </router-link>

              </li>

              <li>

                <button class="preview-option" @click="confirmDelete">

                  <span>                    
                    Delete
                  </span>

                </button>

              </li>

            </ul>            

          </div>

        </div>

      </div>

      <div class="preview-inner">

        <iframe height="1500" width="1100"
                frameBorder="0"
                :src="`workshop/preview/${pattern.name}`"></iframe>


      </div>

    </div>

    <confirmation-window
            v-if="showDeleteConfirm"
            @confirm-yes="deletePattern(pattern.name)"
            @confirm-no="showDeleteConfirm = false">
      Do you really want to delete '{{ pattern.name }}'?
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
          name: this.$route.params.pattern
        },
        loading: false,
        isToggled: false,
        showOptions: false,
        showDescription: false,
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

    mounted() {

      /*
       * Trigger delete confirmation on DEL key.
       */
      window.addEventListener('keyup', (event) => {
        if (event.keyCode === 46) {
          this.confirmDelete();
        }
      });
    },

    /**
     * Load all Pattern information from API.
     */
    created() {
      this.fetchPattern();
    }
  }
</script>