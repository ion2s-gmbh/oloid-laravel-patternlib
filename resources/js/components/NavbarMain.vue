<template>
  <li class="pattern u-center active"> <!-- can be active -->

    <navbar-link v-if="menu.items.length === 0"
                 :item="menu">
    </navbar-link>

    <div v-if="menu.items.length > 0">
      <!--<span>{{ menu.name }}</span>-->
      <!--<i class="fas fa-caret-down"></i>-->
      <navbar-group
              :name="menu.name"
              :items="menu.items">
      </navbar-group>
    </div>
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