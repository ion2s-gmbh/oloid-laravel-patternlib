<template>
  <div class="popUp">

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

        <!-- <router-link :to="{ name: 'preview', params: { patternName: currentName }}">
          <span>Cancel</span>
        </router-link> -->

        <button type="button"
                class="btn btn--cancel "
                @click.prevent="close">
          <span>Cancel</span>
        </button>

        <button @click.prevent="save" class="btn btn--primary">
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
  import {API} from '../restClient';
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
        this.$router.back();
      },

      /**
       * Save the new name of the pattern.
       * @returns {Promise<void>}
       */
      save: async function () {
        /*
         * Validate the name
         */
        try {
          const valid = await this.$validator.validate();

          /*
           * API request
           */
          if (valid) {
            const response = await API.put(`pattern/${this.currentName}`, {
              name: this.pattern.name
            });

            this.$store.commit('reloadNavi', true);
            this.$router.push({
              name: 'preview',
              params: {patternName: this.pattern.name}
            });
          }
        } catch (e) {
          LOG.error(e);
        }
      }
    }
  }
</script>