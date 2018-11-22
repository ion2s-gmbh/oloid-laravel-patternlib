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
            path: 'atoms',
            items: [
              {
                name: 'buttons',
                path: 'atoms.buttons',
                items: [
                  {
                    name: 'positive',
                    path: 'atoms.buttons.positive',
                    items: [
                      {
                        name: 'submit',
                        path: 'atoms.buttons.positive.submit',
                        items: []
                      },
                      {
                        name: 'order',
                        path: 'atoms.buttons.positive.order',
                        items: []
                      }
                    ]
                  },
                  {
                    name: 'negative',
                    path: 'atoms.buttons.negative',
                    items: [
                      {
                        name: 'cancel',
                        path: 'atoms.buttons.negative.cancel',
                        items: []
                      },
                      {
                        name: 'abort',
                        path: 'atoms.buttons.negative.abort',
                        items: []
                      }
                    ]
                  }
                ]
              },
              {
                name: 'headline1',
                path: 'atoms.headline1',
                items: []
              }
            ]
          },
          {
            name: 'pages',
            path: 'pages',
            items: [
              {
                name: 'about',
                path: 'pages.about',
                items: []
              },
              {
                name: 'home',
                path: 'pages.home',
                items: []
              },
            ]
          },
          {
            name: 'landingpage',
            path: 'landingpage',
            items: []
          },
          {
            name: 'about',
            path: 'about',
            items: []
          }
        ]
      }
    }
    }

</script>