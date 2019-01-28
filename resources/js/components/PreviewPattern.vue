<template>

  <div class="view--inner">

    <div class="code">

      <div class="code-el">

        <div class="code-header">

          <div class="code-lang">

            <span v-if="!isToggled" class="code-type a-fadeIn">HTML</span>

            <span v-if="isToggled" class="code-type a-fadeIn">Blade</span>

            <label class="toggle-wrap" v-tooltip.top-center="'Switch between HTML and Blade'">

              <input type="checkbox" class="toggle" v-model="isToggled" />

              <div></div>

              <span>Show Blade</span>

            </label>

          </div>

          <button class="toggle--more clipboard"
                  v-tooltip.top-center="usageTooltip"
                  data-clipboard-target="#usage"
                  @mouseleave="resetTooltip">

            <i class="far fa-clipboard"></i>

          </button> 

          <!-- Hidden usage for copy to clipboard -->
          <span id="usage" class="u-transparent">{{ pattern.usage }}</span>         

        </div>

        <div class="code-tabs">

          <div class="tab a-fadeIn" role="tabpanel" aria-labelledby="markup-view" v-show="isToggled" >

            <pre><code class="code-template language-html">{{ pattern.template }}</code></pre>

          </div>

          <div class="tab a-fadeIn" id="html-view" role="tabpanel" aria-labelledby="html-view" v-show="!isToggled" >

            <pre><code class="code-html language-html">{{ pattern.html }}</code></pre>

          </div>

        </div>

      </div>

      <div class="code-el">

        <div class="code-header">

          <span>CSS/SCSS</span>

        </div>

        <div class="code-tabs">

          <div class="tab" id="markup-view" role="tabpanel" aria-labelledby="markup-view">

            <pre><code class="code-sass language-css">{{ pattern.sass }}</code></pre>

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
                  v-on-clickaway="resetDropdowns"
                  :status="pattern.status">
          </status-bar>

          <button class="toggle--more" @click="showDescription = !showDescription" :class="{ active: showDescription }" v-tooltip.top-center="'Show pattern description'">

            <i class="fas fa-align-left"></i>

          </button>

          <a class="toggle--more"
             :href="`workshop/preview/${pattern.name}`"
             target="_blank"
             v-tooltip.top-center="'Open in fullscreen'">

            <i class="fas fa-external-link-alt"></i>

          </a>

          

        </div>

        <template v-if="totalRejectedCount">
          
          <div class="warning">

            <p class="warning-message">
              This item contains rejected patterns: 
            </p>

            <button class="toggle--more toggle--showIncludes"
                    @click="showWarningIncludes = !showWarningIncludes"
                    v-tooltip.top-center="'Show components that cause this message'">

              <span v-if="!showWarningIncludes" class="a-slideIn">Show</span>

              <span v-if="showWarningIncludes" class="a-slideIn">Hide</span>

            </button>

            <!-- TODO:  @seb Make se dröpdöwn close when se ossas are open -->

            <div class="warning-includes a-dropIn" v-if="showWarningIncludes">

              <ul class="warning-list">

                <li v-for="rejected in pattern.subPatterns.rejected" class="warning-listItemWrap">

                  <router-link :to="{ name: 'preview', params: { patternName: `${rejected}` }}"  class="warning-listItem">
                    {{ rejected }}
                  </router-link>

                </li>

              </ul>

            </div>

          </div>

        </template>


        <template v-if="showDescription">

          <div class="preview-description a-dropIn"
               v-html="markdownDescription"
               @click="editDescription">
          </div>

          <form method="post" class="preview-description" v-if="editModeDescription">

            <label for="description">

              <span class="label-name">
                Description <span>(optional)</span>
              </span>

            </label>


            <textarea id="description"
                      class="form-control"
                      name="description"
                      @keydown.ctrl.83.prevent="updatePattern"
                      @keydown.esc="cancelDescription"
                      v-model="pattern.description" autofocus>{{ pattern.description }}</textarea>

            <div class="form-group form-group--end">

              <button type="button"
                      class="btn btn--primary btn--sm"
                      @click="cancelDescription">
                <span>Cancel</span>
              </button>

              <button type="button"
                      class="btn btn--primary btn--sm"
                      @click="updatePattern">
                <span>Save</span>
              </button>

            </div>

          </form>

        </template>

        <div class="preview-optionsWrap">

          <!-- MENUE TOGGLE -->

          <button class="toggle--more"
                  @click.prevent.stop="toggleOptions"
                  :class="{ active: showOptions }">
            
            <i class="fas fa-ellipsis-v"></i>
            
          </button>

          <!-- ACTUAL MENUE -->

          <div class="preview-menu a-dropIn" v-if="showOptions">

            <ul class="preview-list">              

              <li class="preview-optionWrap">

                <router-link :to="{ name: 'rename', params: { pattern: `${pattern.name}` } }" class="preview-option">

                  <span>
                    Rename Pattern
                  </span>

                </router-link>

              </li>

              <li class="preview-optionWrap">

                <button @click="confirmDelete" class="preview-option">

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

    <shortcuts v-if="showKeyMap"
               :globalKeymap="globalShortcuts"
               :pageKeymap="previewShortcuts">
    </shortcuts>

  </div>

</template>

<script>
  import StatusBar from './StatusBar';
  import ConfirmationWindow from './ConfirmationWindow';
  import Shortcuts from './Shortcuts'
  import {API} from '../restClient';
  import LOG from '../logger';
  import marked from 'marked';
  import ClipboardJS from 'clipboard';
  import {globalShortcuts, previewShortcuts, showKeyMap} from '../shortcuts';
  import Prism from 'prismjs';
  import {keyPressed} from "../helpers";
  import {mixin as clickaway} from 'vue-clickaway'

  export default {
    name: "PreviewPattern",

    mixins: [clickaway],

    components: {
      ConfirmationWindow,
      StatusBar,
      Shortcuts
    },

    props: [
      'patternName'
    ],

    data() {
      return {
        pattern: {
          name: this.patternName,
          description: '',
          subPatterns: {
            todo: [],
            review: [],
            rejected: [],
            done: []
          }
        },
        loading: false,
        isToggled: false,
        showDescription: false,
        showDeleteConfirm: false,
        showWarningIncludes: false,
        editModeDescription: false,
        oldDescription: '',
        usageTooltip: {
          content: 'Copy usage to clipboard',
          hideOnTargetClick: false
        },
        globalShortcuts,
        previewShortcuts,
        optionsDropdown: 'PreviewPattern::dropdown-options'
      }
    },

    computed: {
      /**
       * Imported computed properties
       */
      showKeyMap,

      /**
       * Parse the given description markdown to html.
       */
      markdownDescription: function () {
        return marked(this.pattern.description);
      },

      /**
       * Determine if the options dropdown is active.
       */
      showOptions: function () {
        return this.$store.getters.activeDropdown === this.optionsDropdown;
      },

      /**
       * Get the total of used Patterns with status 'todo' in the current Pattern.
       */
      totalTodoCount: function () {
        return this.pattern.subPatterns.todo.length;
      },

      /**
       * Get the total of used Patterns with status 'review' in the current Pattern.
       */
      totalReviewCount: function () {
        return this.pattern.subPatterns.review.length;
      },

      /**
       * Get the total of used Patterns with status 'rejected' in the current Pattern.
       */
      totalRejectedCount: function () {
        return this.pattern.subPatterns.rejected.length;
      },

      /**
       * Get the total of used Patterns with status 'done' in the current Pattern.
       */
      totalDoneCount: function () {
        return this.pattern.subPatterns.done.length;
      }
    },

    watch: {
      'pattern.sass': function (value) {
          const codeBox = document.querySelector('.code-sass');
        this.resetCodeBox(value, codeBox);
      },
      'pattern.html': function (value) {
        const codeBox = document.querySelector('.code-html');
        this.resetCodeBox(value, codeBox);
      },
      'pattern.template': function (value) {
        const codeBox = document.querySelector('.code-template');
        this.resetCodeBox(value, codeBox);
      }
    },

    methods: {

      /**
       * Reset the textContent of the highlighted code element.
       * In the next tick, this code is highlighted with Prismjs.
       */
      resetCodeBox: function (value, codeBox) {
        codeBox.textContent = value;
        this.$nextTick(() => {
          Prism.highlightElement(codeBox);
        });
      },

      /**
       * Reset the tooltip to the initial content.
       * @todo Improve this in the future.
       */
      resetTooltip: function () {
        this.usageTooltip.content = 'Copy usage to clipboard';
      },

      /**
       * Navigate to the rename pattern view. This is triggered by a shortcut.
       */
      renamePattern: function () {
        this.$router.push({
          name: 'rename',
          params: { pattern: this.pattern.name }
        })
      },

      /**
       * Enable the edit mode for the description field.
       */
      editDescription: function () {
        this.editModeDescription = true;
        this.oldDescription = this.pattern.description
      },

      /**
       * Cancel the editing of the description and reset to old value.
       */
      cancelDescription: function () {
        this.editModeDescription = false;
        this.pattern.description = this.oldDescription;
      },

      /**
       * Update the Pattern with the new description.
       */
      updatePattern: async function () {
        this.editModeDescription = false;
        try {
          const response = await API.put(`pattern/${this.pattern.name}`, {
            description: this.pattern.description
          });
        } catch (e) {
          /*
           * Reset the value on error.
           */
          this.pattern.description = this.oldDescription;
          LOG.error(e);
        }
      },

      /**
       * Fetch the Pattern's data from the API.
       */
      fetchPattern: async function (patternName) {
        // set to true, if we have to show a loading spinner
        this.loading = true;
        try {
          const response = await API.get(`pattern/preview/${patternName}`);
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
          const response = await API.put(`pattern/status/${this.pattern.name}`, {
            status
          });
          this.pattern.status = status;
        } catch (e) {
          LOG.error(e);
        }
      },

      /**
       * Show the delete confirmation window (modal).
       */
      confirmDelete: function () {
        this.showDeleteConfirm = true;
      },

      /**
       * Delete the pattern
       * @param pattern
       */
      deletePattern: async function (pattern) {
        try {
          const response = await API.delete(`pattern/${pattern}`);
          this.$store.commit('reloadNavi', true);
          this.$router.push('/');
        } catch (e) {
          LOG.error(e);
        }
      },

      /**
       * Toggle the options dropdown
       */
      toggleOptions: function () {
        this.$store.dispatch('toggleDropdown', this.optionsDropdown);
      },

      /**
       * Reset dropdowns if clicked somewhere else.
       */
      resetDropdowns: function () {
        this.$store.dispatch('resetDropdowns');
      }
    },

    /**
     * Fetch Pattern on route change.
     * @param to
     * @param from
     * @param next
     */
    beforeRouteUpdate (to, from, next) {
      this.fetchPattern(to.params.patternName);
      next();
    },

    /**
     * Fetch Pattern on created hook.
     */
    created() {
      this.fetchPattern(this.patternName);
    },

    mounted() {

      /**
       * Clipboard initialization.
       */
      let clipboard = new ClipboardJS('.clipboard');
      clipboard.on('success', (e) => {
        this.usageTooltip.content = 'Copied to clipboard';
      });

      /**
       * Global shortcuts
       */
      window.addEventListener('keydown', (event) => {

        const DEL = 46;
        const E = 69;

        const key = keyPressed(event);

        /*
         * Trigger the delete confirmation by Ctrl+DEL
         */
        if (event.ctrlKey && key === DEL) {
          event.preventDefault();
          this.confirmDelete();
        }

        /*
         * Trigger renaming of the Pattern by Ctrl+E
         */
        if (event.ctrlKey && key === E) {
          event.preventDefault();
          this.renamePattern();
        }
      });
    }
  }
</script>