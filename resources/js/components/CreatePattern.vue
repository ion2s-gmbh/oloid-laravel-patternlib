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

  </div>

</template>

<script>
  import {API} from '../httpClient';
  import LOG from '../logger';

  export default {
    name: "CreatePattern",
    data() {
      return {
        pattern: {}
      }
    },
    methods: {

      cancel: function () {
        this.$router.push({
          name: 'dashboard'
        });
      },

      /**
       * Save a new Pattern
       */
      save: async function () {
        /*
         * Validate the form
         */
        let valid = false;
        try {
          valid = await this.$validator.validate();
        } catch (e) {
          LOG.error(e);
        }

        /*
        * API request
        */
        if (valid) {
          try {
            let response = await API.post('pattern', {
              'name': this.pattern.name,
              'description': this.pattern.description
            });
            if (response.status === 201) {
              this.$store.commit('reloadNavi', true);
              this.$router.push('/preview/' + this.pattern.name);
            }
          } catch (e) {
            LOG.error(e.status);
          }
        }
      }
    }
  }
</script>