<template>
  <li class="pattern u-center" :class="{ active: $store.state.menu.activeMain === menu.name }">

    <!-- Single stupid link to a pattern -->
    <navbar-link v-if="menu.items.length === 0"
                 :item="menu">
    </navbar-link>

    <!-- We have a menu with multiple items -->
    <span v-if="menu.items.length > 0"
          @click="toggleMainMenu(menu.name)">{{ menu.name }}</span>
    <navbar-group
            v-if="menu.items.length > 0"
            :name="menu.name"
            :items="menu.items">
    </navbar-group>
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

        if (this.$store.state.menu.activeMain === menu) {
          this.$store.commit('resetMainMenu');
        } else {
          this.$store.commit('toggleMainMenu', menu);
        }
      }
    }
  }
</script>