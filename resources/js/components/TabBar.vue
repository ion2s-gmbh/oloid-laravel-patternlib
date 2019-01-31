<template>

  <nav>

    <ul class="tabs-list">

      <li class="tab"
          v-for="(tab, index) in tabs"
          :class="{active: selected === tab }"
          :key="index"
          @click="selected = tab">

        <span>{{tab}}</span>

      </li>

    </ul>

  </nav>

</template>

<script>
  export default {
    name: "TabBar",

    data() {
      return {
        tabs: ['for <head>','above </body>'],
        selected: 'for <head>'
      }
    }
  }
</script>