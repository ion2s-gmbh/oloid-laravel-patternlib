<template>
  <div class="row">
    <div class="col-md-3">

      <div class="card" v-if="$store.state.devMode">
        <div class="card-header">
          Pattern management
        </div>
        <div class="card-body">
          <div class="py-1">
            <router-link :to="{ name: 'create' }">
              <button class="btn btn-primary">
                <i class="fas fa-plus-square"></i>
                NEW PATTERN
              </button>
            </router-link>
          </div>

          <div class="py-1">
            <router-link :to="{ name: 'preview' }">
              <button class="btn btn-primary">
                <i class="fas fa-eye"></i>
                PREVIEW PATTERN
              </button>
            </router-link>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Dashboard"
  }
</script>