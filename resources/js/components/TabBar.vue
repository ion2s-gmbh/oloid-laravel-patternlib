<template>

  <nav>

    <ul class="tabs-list">

      <li class="tab"
          v-for="(tab, index) in tabs"
          :class="{active: selectedItem === tab }"
          :key="index"
          @click="selectedItem = tab">

        <span>{{tab}}</span>

      </li>

    </ul>

  </nav>

</template>

<script>
  export default {
    name: "TabBar",

    props: [
      'tabs',
      'selected'
    ],

    data() {
      return {
        selectedItem: this.tabs[this.selected]
      }
    }
  }
</script>