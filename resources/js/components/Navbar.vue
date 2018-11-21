<template>

  <section class="project">


    <div class="project-info">

      <h1 class="project-name">{{ $store.state.appInfo.appName }}</h1>

    </div>

    <nav class="project-navigation">

      <ul class="patterns">

        <navbar-main
                v-for="(menu, index) in navi"
                :menu="menu" :key="index">
        </navbar-main>

        <!--<li class="pattern u-center"-->
            <!--:class="{ active: $store.state.menu.activeMain === menu.name }"-->
            <!--v-for="menu in navi">-->
          <!--<span @click="toggleMainMenu(menu.name)">{{ menu.name }}</span>-->
          <!--<ul class="patterns&#45;&#45;sub">-->
            <!--<li class="pattern"-->
                <!--v-if="item.items.length === 0"-->
                <!--v-for="item in menu.items">-->
              <!--<router-link :to="{ name: 'preview', params: { pattern: `${menu.name}.${item.name}` } }">-->
                <!--{{ item.name }}-->
              <!--</router-link>-->
            <!--</li>-->
            <!--<li class="pattern"-->
                <!--v-if="item.items.length > 0"-->
                <!--v-for="item in menu.items"-->
                <!--:class="{ active: $store.state.menu.activeSub === item.name }">-->
              <!--<span @click="toggleSubMenu(item.name)">{{ item.name }}-->
                <!--<i class="fas fa-caret-down"></i>-->
              <!--</span>-->
              <!--<ul class="patterns&#45;&#45;sub">-->
                <!--<li class="pattern"-->
                    <!--v-for="subItem in item.items">-->
                  <!--<router-link-->
                          <!--:to="{ name: 'preview', params: { pattern: `${menu.name}.${item.name}.${subItem.name}` } }">-->
                    <!--{{ subItem.name }}-->
                  <!--</router-link>-->
                <!--</li>-->
              <!--</ul>-->
            <!--</li>-->
          <!--</ul>-->
        <!--</li>-->
      </ul>
    </nav>

  </section>

</template>

<script>

  import NavbarMain from "./NavbarMain";
  import NavbarLink from "./NavbarLink";
  import NavbarGroup from "./NavbarGroup";

  export default {
    name: "Navbar",
    components: {
      NavbarMain,
      NavbarLink,
      NavbarGroup
    },

    data() {
      return {
        navi: [
          {
            name: 'atoms',
            items: [
              {
                name: 'buttons',
                items: [
                  {
                    name: 'button',
                    items: [
                      {
                        name: 'marek',
                        items: []
                      }
                    ]
                  },
                  {
                    name: 'cancel',
                    items: []
                  }
                ]
              },
              {
                name: 'headline1',
                items: []
              }
            ]
          },
          {
            name: 'pages',
            items: [
              {
                name: 'about',
                items: []
              },
              {
                name: 'home',
                items: []
              },
            ]
          },
          {
            name: 'landingpage',
            items: []
          },
          {
            name: 'about',
            items: []
          }
        ]
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