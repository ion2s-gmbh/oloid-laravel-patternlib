<template>
  <li class="pattern u-center" :class="{ active: $store.getters.isActiveMainMenu(menu.path) }">

    <!-- Single link to a pattern -->
    <navbar-link v-if="!menu.items.length"
                 :item="menu">
    </navbar-link>

    <!-- We have a menu with multiple items -->
    <template v-if="menu.items.length">
      <span @click="toggleMainMenu(menu.name)">{{ menu.path }}</span>
      <navbar-group
              :name="menu.name"
              :items="menu.items">
      </navbar-group>
    </template>

  </li>
</template>

<script>
  import NavbarLink from "./NavbarLink";
  import NavbarGroup from "./NavbarGroup";

  export default {
    name: "NavbarMain",

    components: {
      NavbarGroup,
      NavbarLink
    },

    props: [
      'menu'
    ],

    methods: {
      /**
       * Set the active main menu.
       * @param menu
       */
      toggleMainMenu: function (menu) {

        if (this.$store.getters.isActiveMainMenu(menu)) {
          this.$store.commit('resetMenu');
        } else {
          this.$store.commit('toggleMainMenu', menu);
        }
      }
    }
  }
</script>