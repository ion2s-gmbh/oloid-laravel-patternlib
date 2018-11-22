<template>
  <ul class="patterns--sub">

    <li class="pattern" v-for="item in items">
      <navbar-link v-if="item.items.length === 0"
                   :parent="name"
                   :item="item">
      </navbar-link>

      <span v-if="item.items.length > 0">{{ item.name }}</span>
      <i v-if="item.items.length > 0" class="fas fa-caret-down"></i>
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

    mounted() {
      console.log(this.name);
    }
  }
</script>