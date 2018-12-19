<template>
  <ul class="patterns--sub">

    <li class="pattern" v-for="item in items"
        :class="{ active: $store.getters.isActiveSubmenu(item.path) }">
      <navbar-link v-if="!item.items.length"
                   :parent="name"
                   :item="item">
      </navbar-link>

      <span v-if="item.items.length"
            @click="toggleSubMenu(item.path)">{{ item.name }}
        <i class="fas fa-caret-down"></i>
      </span>
      <navbar-group
              :name="item.name"
              :items="item.items">
      </navbar-group>
    </li>
  </ul>

</template>

<script>
  import NavbarLink from "./NavbarLink";

  export default {
    name: "NavbarGroup",

    components: {
      NavbarLink
    },

    props: [
      'name',
      'items'
    ],

    methods: {

      /**
       * Set the active sub menu.
       * @param subMenu
       */
      toggleSubMenu: function (subMenu) {
        if (this.$store.getters.isActiveSubmenu(subMenu)) {
          let pathComponents = subMenu.split('.');
          pathComponents.pop();
          subMenu = pathComponents.join('.');
        }
        this.$store.commit('toggleSubMenu', subMenu);
      }
    }
  }
</script>