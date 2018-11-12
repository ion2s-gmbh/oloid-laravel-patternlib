<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Create a new pattern</div>

          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <label for="name">Name</label>
                <small id="nameHelp" class="form-text text-muted">E.g. atoms.buttons.button</small>
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
                <label for="description">Description</label>
                <textarea id="description"
                          class="form-control"
                          name="description"
                          v-model="pattern.description"
                          v-validate.disable="'required'"
                          placeholder="Describe your pattern ..."></textarea>
                <small class="error">{{ errors.first('description') }}</small>
              </div>

              <div class="form-group">
                <button @click.prevent="store" class="btn btn-primary">
                  <i class="fas fa-pen-alt"></i>
                  SAVE
                </button>
                <router-link :to="{ name: 'dashboard' }">CANCEL</router-link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {API} from '../httpClient';

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
                console.error(e.status);
              }
            }
          });
      }
    }
  }
</script>