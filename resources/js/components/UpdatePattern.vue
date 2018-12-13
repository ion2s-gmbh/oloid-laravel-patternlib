<template>
  <div class="dashboard">

    <form method="post" class="form form--create">

      <div class="form-group">

        <label for="name">

          <span class="label-name">Name</span>
          <span class="label-hint">E.g. atoms.buttons.button</span>
          <small class="error a-slideIn" v-if="errors.has('name')">{{ errors.first('name') }}</small>

        </label>

        <input id="name"
               class="form-control"
               type="text"
               name="name"
               v-model="pattern.name"
               aria-describedby="nameHelp"
               @keydown.ctrl.83.prevent="save"
               @keydown.esc="cancel"
               v-validate.disable="'required|uniquePattern'"
               autofocus
        />

      </div>

      <div class="form-group form-group--end">

        <router-link :to="{ name: 'preview', params: { patternName: currentName }}">
          <span>Cancel</span>
        </router-link>

        <button @click.prevent="save" class="btn btn--primary btn--sm">
          <span>Save</span>
        </button>


      </div>

    </form>

    <shortcuts v-if="showKeyMap"
               :globalKeymap="globalShortcuts"
               :pageKeymap="updateShortcuts">
    </shortcuts>

  </div>
</template>

<script>
  import LOG from '../logger';
  import {API} from '../httpClient';
  import Shortcuts from './Shortcuts'
  import {globalShortcuts, showKeyMap, updateShortcuts} from "../shortcuts";

  export default {
    name: "UpdatePattern",

    components: {
      Shortcuts
    },

    props: [
      'patternName'
    ],

    data() {
      return {
        pattern: {
          name: this.patternName
        },
        currentName: this.patternName,
        globalShortcuts,
        updateShortcuts
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
       * Cancel the renaming of the pattern by navigating back to the preview page.
       */
      cancel: function () {
        this.$router.push({
          name: 'preview',
          params: { pattern: this.currentName }
        });
      },

      /**
       * Save the new name of the pattern.
       * @returns {Promise<void>}
       */
      save: async function () {
        /*
         * Validate the name
         */
        let valid = false;
        try {
          valid = await this.$validator.validate();
        } catch (e) {
          LOG.error(e);
        }

        if (valid) {
          try {
            let response = await API.put(`pattern/${this.currentName}`, {
              name: this.pattern.name
            });

            this.$store.commit('reloadNavi', true);
            this.$router.push({
              name: 'preview',
              params: { pattern: this.pattern.name }
            });
          } catch (e) {
            LOG.error(e);
          }
        }
      }
    }
  }
</script>