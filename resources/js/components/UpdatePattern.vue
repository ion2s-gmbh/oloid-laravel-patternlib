<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Update pattern {{ patternName }}</div>

          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <label for="name">Name</label>
                <input id="name" class="form-control" type="text" name="name"
                       aria-describedby="nameHelp"
                       placeholder="nested.pattern.name"/>
                <small id="nameHelp" class="form-text text-muted">E.g. atoms.buttons.button</small>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" name="description"
                          placeholder="Describe your pattern ..."></textarea>
              </div>

              <div class="form-group">
                <button @click.prevent="update" class="btn btn-primary">
                  <i class="fas fa-pen-alt"></i>
                  SAVE
                </button>
                <router-link :to="{ name: 'preview', params: { pattern: patternName }}">CANCEL</router-link>
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
    name: "UpdatePattern",

    data() {
      return {
        patternName: this.$route.params.pattern
      }
    },

    methods: {
      update: function() {
        alert('update pattern');
        this.$router.push({
          name: 'preview',
          params: { pattern: this.patternName }
        });
      }
    }
  }
</script>