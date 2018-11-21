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
                v-if="typeof item !== 'object'"
                v-for="item in menu.items">

              <router-link :to="{ name: 'preview', params: { pattern: `${menu.name}.${item}` } }">

                {{ item }}

              </router-link>

            </li>

            <li class="pattern"
                v-if="typeof item === 'object'"
                v-for="item in menu.items"
                :class="{ active: item.name === activeSubMenu }">

              <span @click="toggleSubMenuItem(item.name)">{{ item.name }}

                <i class="fas fa-caret-down"></i>

              </span>

              <ul class="patterns--sub">

                <li class="pattern"
                    v-for="subItem in item.items">

                  <router-link :to="{ name: 'preview', params: { pattern: `${menu.name}.${item.name}.${subItem}` } }">

                    {{ subItem }}

                  </router-link>

                </li>

              </ul>

            </li>

          </ul>

        </li>

      </ul>

    </nav>

  </section>

</template>

<script>

  export default {

    name: "Navbar",

    data() {

      return {
        'active': false,
        'navi': {
          'main': [
            {
              'name': 'atoms',
              'items': [
                {
                  'name': 'buttons',
                  'items': [
                    'submit',
                    'cancel'
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
              'name': 'elements',
              'items': []
            }
          ]
        },
        activeMainMenu: '',
        activeSubMenu: ''
      }
    },
    methods: {
      toggleMainMenuItem: function (menu) {
        if (this.activeMainMenu === menu) {
          this.activeMainMenu = '';
        } else {
          this.activeMainMenu = menu;
        }
      },
      toggleSubMenuItem: function (subMenu) {
        console.log(subMenu);
        if (this.activeSubMenu === subMenu) {
          this.activeSubMenu = '';
        } else {
          this.activeSubMenu = subMenu;
        }
      }
    }

  }

</script>