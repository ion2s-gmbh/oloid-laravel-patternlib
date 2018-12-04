<template>
  <!--<div class="container">-->
    <!--<div class="row justify-content-center">-->
      <!--<div class="col-md-8">-->
        <!--<div class="card">-->
          <!--<div class="card-header">Update pattern {{ patternName }}</div>-->

          <!--<div class="card-body">-->
            <!--<form method="post">-->
              <!--<div class="form-group">-->
                <!--<label for="name">Name</label>-->
                <!--<input id="name" class="form-control" type="text" name="name"-->
                       <!--aria-describedby="nameHelp"-->
                       <!--placeholder="nested.pattern.name"/>-->
                <!--<small id="nameHelp" class="form-text text-muted">E.g. atoms.buttons.button</small>-->
              <!--</div>-->

              <!--<div class="form-group">-->
                <!--<button @click.prevent="update" class="btn btn-primary">-->
                  <!--<i class="fas fa-pen-alt"></i>-->
                  <!--Save-->
                <!--</button>-->
                <!--<router-link :to="{ name: 'preview', params: { pattern: patternName }}">Cancel</router-link>-->
              <!--</div>-->
            <!--</form>-->
          <!--</div>-->
        <!--</div>-->
      <!--</div>-->
    <!--</div>-->
  <!--</div>-->
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
               v-validate.disable="'required|uniquePattern'"
        />


      </div>

      <div class="form-group form-group--end">

        <router-link :to="{ name: 'preview', params: { pattern: currentName }}">
          <span>Cancel</span>
        </router-link>

        <button @click.prevent="update" class="btn btn--primary btn--sm">
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
      update: async function() {
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