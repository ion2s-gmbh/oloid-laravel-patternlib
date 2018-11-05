<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Create a new pattern</div>

          <div class="card-body">
            <!--<form method="post" action="{{ route('store-pattern') }}">-->
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
                <button @click.prevent="createPattern" class="btn btn-primary">
                  <i class="fas fa-pen-alt"></i>
                  SAVE
                </button>
                <!--<a href="{{ route('workshop') }}">Cancel</a>-->
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
        createPattern: function() {
          alert('create pattern');
          this.$router.push('/preview');
        }
    }
  }
</script>