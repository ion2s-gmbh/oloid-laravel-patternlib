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

        <router-link :to="{ name: 'preview', params: { pattern: currentName }}">
          <span>Cancel</span>
        </router-link>

        <button @click.prevent="save" class="btn btn--primary btn--sm">
          <span>Save</span>
        </button>


      </div>

    </form>

  </div>
</template>

<script>
  import LOG from '../logger';
  import {API} from '../httpClient';

  export default {
    name: "UpdatePattern",

    data() {
      return {
        pattern: {
          name: this.$route.params.pattern
        },
        currentName: this.$route.params.pattern
      }
    },

    methods: {

      cancel: function () {
        this.$router.push({
          name: 'preview',
          params: { pattern: this.currentName }
        });
      },

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