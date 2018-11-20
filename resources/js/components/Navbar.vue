<template>

  <section class="project">

    
    <div class="project-info">

      <h1 class="project-name">{{ $store.state.appInfo.appName }}</h1>
      
      <!-- <div class="project-updates">
        <button class="btn">
            <i class="fas fa-bell"></i>
          </button>
      </div> -->

    </div>


    <nav class="project-navigation">

      <ul class="patterns">
        
        <li class="pattern u-center" @click="active = !active" :class="{ active: active }">
          
          Atoms

          <ul class="patterns--sub">

            <li class="pattern">

              <a href="">Label</a>

            </li>

            <li class="pattern">headline one</li>

            <li class="pattern">
          <!-- TODO:  this must be active on click -  can't use the same logic here or else it will be automatically applied -->

              <a href="">
                Buttons
                <i class="fas fa-caret-down"></i> <!-- TODO: Only display when has children -->
              </a>

              <ul class="patterns--sub">
              
                <li class="pattern">btn_submit</li>

                <li class="pattern">btn_form</li>
                
              </ul>

            </li>

            <li class="pattern">Bla</li>
            <li class="pattern">text</li>

          </ul>

        </li>

        <li class="pattern u-center">
          
          Forms

        </li>

      </ul>

      <!-- <router-link :to="{ name: 'create' }">
        
        <button class="btn btn--create">
          <i class="fas fa-plus-square"></i>
        </button>

      </router-link> -->

    </nav>
    
  </section>

</template>

<script>

  export default {

    name: "Navbar",

    data() {

      return {
        active: false
      }

    }

  }

</script>