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
            :class="{ active: $store.state.menu.activeMain === menu.name }"
            v-for="menu in navi.main"
            v-if="menu.items.length > 0">

          <span @click="toggleMainMenu(menu.name)">{{ menu.name }}</span>

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
                :class="{ active: $store.state.menu.activeSub === item.name }">

              <span @click="toggleSubMenu(item.name)">{{ item.name }}

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
        'navi': {
          'main': [
            {
              'name': 'atoms',
              'items': [
                {
                  'name': 'buttons',
                  'items': [
                    'button',
                    'cancel',
                    'submit.save',
                    'submit.update'
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
      }
    },
    methods: {

      /**
       * Set the active main menu.
       * @param menu
       */
      toggleMainMenu: function (menu) {

        if (this.$store.state.menu.activeMain === menu) {
          this.$store.commit('resetMainMenu');
        } else {
          this.$store.commit('toggleMainMenu', menu);
        }
      },

      /**
       * Set the active sub menu.
       * @param subMenu
       */
      toggleSubMenu: function (subMenu) {
        if (this.$store.state.menu.activeSub === subMenu) {
          this.$store.commit('resetSubMenu');
        } else {
          this.$store.commit('toggleSubMenu', subMenu);
        }
      }
    }

  }

</script>