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
               v-validate.disable="'required'"
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
                  v-model="pattern.description">
                    
          </textarea>

      </div>

      <div class="form-group form-group--end">

        <router-link :to="{ name: 'dashboard' }">
          <span>Cancel</span>
        </router-link>

        <button @click.prevent="store" class="btn btn--primary btn--sm">
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

      /**
       * Store a new Pattern
       */
      store: function () {
        this.$validator.validate()
          .then(async result => {
            if (result) {
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
          });
      }
    }
  }
</script>