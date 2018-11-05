<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">{{ appName }}</a>
    <router-link :to="{ name: 'dashboard' }" class="navbar-brand">Workshop</router-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <!--@foreach($navbar->sections() as $section)-->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false">
            <!--{{ strtoupper($section) }}-->
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <!--@foreach($navbar->patterns($section) as $pattern)-->
            <!--<a href="{{ route('preview-pattern', ['pattern' => $navbar->slug($pattern)]) }}">{{ $pattern }}</a><br>-->
            <!--@endforeach-->
          </div>
        </li>
        <!--@endforeach-->
      </ul>
      <router-link :to="{ name: 'create' }">
        <button class="btn btn-primary">
          <i class="fas fa-plus-square"></i>
        </button>
      </router-link>
    </div>
  </nav>
</template>

<script>
  export default {
    name: "Navbar",
    data() {
      return {
        appName: 'Laravel'
      }
    }
  }
</script>