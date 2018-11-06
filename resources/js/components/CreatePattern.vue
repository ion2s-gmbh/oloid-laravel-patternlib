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
  export default {
    name: "CreatePattern",
    methods: {
        store: function() {
          this.$validator.validate()
            .then(result => {
              if (result) {
                this.$router.push('/preview');
              }
            });
        }
    }
  }
</script>