<template>
  <li class="pattern active">
    <!--<span @click="toggleMainMenu(item.name)">{{ item.name }}</span>-->
    <span>{{ name }}</span>
    <i class="fas fa-caret-down"></i>

    <ul class="patterns--sub">
      <li class="pattern" v-for="item in items">
        <navbar-link v-if="item.items.length === 0"
                     :parent="name"
                     :item="item">
        </navbar-link>

        <navbar-group v-else-if="item.items.length > 0"
                      :name="item.name"
                      :items="item.items">
        </navbar-group>
      </li>
    </ul>
  </li>

  <!--</li>-->
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