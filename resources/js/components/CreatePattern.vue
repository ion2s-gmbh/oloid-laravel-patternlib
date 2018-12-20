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

      <div class="form-group">

        <label for="description">
            
            <span class="label-name">
              Description <span>(optional)</span>
            </span>

          <small class="error a-slideIn" v-if="errors.has('description')">{{ errors.first('description') }}</small>

        </label>

        <textarea id="description"
                  class="form-control"
                  name="description"
                  @keydown.ctrl.83.prevent="save"
                  @keydown.esc="cancel"
                  v-model="pattern.description">
                    
          </textarea>

      </div>

      <div class="form-group form-group--end">

        <router-link :to="{ name: 'dashboard' }">
          <span>Cancel</span>
        </router-link>

        <button class="btn btn--primary btn--sm"
                @click.prevent="save">
          <span>Create pattern</span>
        </button>


      </div>

    </form>

    <shortcuts v-if="showKeyMap"
               :globalKeymap="globalShortcuts"
               :pageKeymap="createShortcuts">
    </shortcuts>

  </div>

</template>

<script>
  import {API} from '../restClient';
  import LOG from '../logger';
  import Shortcuts from './Shortcuts';
  import {createShortcuts, globalShortcuts, showKeyMap} from '../shortcuts';

  export default {
    name: "CreatePattern",

    components: {
      Shortcuts
    },

    data() {
      return {
        pattern: {},
        globalShortcuts,
        createShortcuts
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
       * Cancel the create action by navigating to the dashboard.
       */
      cancel: function () {
        this.$router.back();
      },

      /**
       * Save a new Pattern.
       */
      save: async function () {
        /*
         * Validate the form
         */
        try {
          const valid = await this.$validator.validate();

          /*
           * API request
           */
          if (valid) {
            const response = await API.post('pattern', {
              'name': this.pattern.name,
              'description': this.pattern.description
            });
            if (response.status === 201) {
              this.$store.commit('reloadNavi', true);
              this.$router.push('/preview/' + this.pattern.name);
            } else {
              alert('Pattern could not be saved!');
            }
          }
        } catch (e) {
          LOG.error(e);
        }
      }
    }
  }
</script>