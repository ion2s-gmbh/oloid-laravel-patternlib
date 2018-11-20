<template>

  <div class="dashboard">
    
    <form method="post" class="form form--create">

      <div class="form-group">

        <label for="name">
        
          <span class="label-name">Name</span>
          <span class="label-hint">E.g. atoms.buttons.button</span>

        </label>

        

        <input id="name"
               class="form-control"
               type="text"
               name="name"
               v-model="pattern.name"
               aria-describedby="nameHelp"
               placeholder="nested.pattern.name"
               v-validate.disable="'required'"
        />

        <small class="error">{{ errors.first('name') }}</small>

      </div>

        <div class="form-group">
          
          <label for="description">
            
            <span class="label-name">
              Description <span>(optional)</span>
            </span>

            <span class="label-hint">E.g. atoms.buttons.button</span>          

          </label>

          <textarea id="description"
                    class="form-control"
                    name="description"
                    v-model="pattern.description"
                    v-validate.disable="'required'"
                    ></textarea>
          <small class="error">{{ errors.first('description') }}</small>
        </div>

        <div class="form-group">
          
          <button @click.prevent="store" class="btn btn-primary">
            <i class="fas fa-pen-alt"></i>
            Create pattern
          </button>

          <router-link :to="{ name: 'dashboard' }">Cancel</router-link>

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