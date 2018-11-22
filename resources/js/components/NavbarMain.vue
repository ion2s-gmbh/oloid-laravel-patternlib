<template>
  <li class="pattern u-center">

    <!-- Single stupid link to a pattern -->
    <navbar-link v-if="menu.items.length === 0"
                 :item="menu">
    </navbar-link>

    <!-- We have a menu with multiple items -->
    <span v-if="menu.items.length > 0">{{ menu.name }}</span>
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

    mounted() {
      console.log(this.menu);
    }
  }
</script>