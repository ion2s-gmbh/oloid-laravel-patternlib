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
        
        <li class="pattern u-center"
            :class="{ active: activeMainMenu === menu.name }"

            v-for="menu in navi.main"
            v-if="menu.items.length > 0">

          <span @click="toggleMainMenuItem(menu.name)">{{ menu.name }}</span>

          <ul class="patterns--sub">

            <li class="pattern"
                v-for="item in menu.items"
                v-if="typeof item === 'object'">
          <!-- TODO:  this must be active on click -  can't use the same logic here or else it will be automatically applied -->

              <div v-for="sub in item.subs"
                   :class="{ active: activeSubMenu === sub.name}"
                   @click="toggleSubMenuItem(sub.name)">
              {{ sub.name }}
                <i class="fas fa-caret-down"></i> <!-- TODO: Only display when has children -->

                <ul class="patterns--sub">

                  <li class="pattern" v-for="subItem in sub.items">
                    <router-link :to="{ name: 'preview', params: { pattern: `${menu.name}.${sub.name}.${subItem}` } }">
                      {{ subItem }}
                    </router-link>
                  </li>

                </ul>

              </div>

            </li>

            <li class="pattern" v-else-if="typeof item !== 'object'">
              <router-link :to="{ name: 'preview', params: { pattern: `${menu.name}.${item}` } }">
                {{ item }}
              </router-link>
            </li>

          </ul>

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
        'navi': {
          'main': [
            {
              'name': 'atoms',
              'items': [
                {
                  'subs': [
                    {
                      'name': 'buttons',
                      'items': [
                        'submit',
                        'cancel'
                      ]
                    }
                  ]
                },
                'headline1'
              ]
            },
            {
              'name': 'pages',
              'items': [
                'about',
                'home',
                'imprint'
              ]
            },
            {
              'name':'elements',
              'items': []
            }
          ]
        },
        activeMainMenu: '',
        activeSubMenu: ''
      }
    },
    methods: {
      toggleMainMenuItem: function(menu) {
        if (this.activeMainMenu === menu) {
          this.activeMainMenu = '';
        } else {
          this.activeMainMenu = menu;
        }
      },
      toggleSubMenuItem: function(subMenu) {
        if (this.activeMainMenu === subMenu) {
          this.activeSubMenu = '';
        } else {
          this.activeSubMenu = subMenu;
        }
      }
    },

    // computed: {
    //   isActive: function () {
        // return this.activeMainMenu === menu;
      // }
    // }

  }

</script>