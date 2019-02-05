<template>

  <nav>

    <ul class="tabs-list">

      <li class="tab"
          v-for="(tab, index) in tabs"
          :class="{active: selectedTab === tab }"
          :key="index"
          @click="changeTab(tab)">

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
        selectedTab: this.tabs[this.selected]
      }
    },

    methods: {
      changeTab: function (tab) {
        this.selectedTab = tab;
        this.$emit('changeTab', tab);
      }
    }
  }
</script>