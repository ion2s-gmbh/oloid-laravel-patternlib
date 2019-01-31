<template>
  <div class="dashboard-container" :class="containerClass">
    <slot></slot>
    <template v-if="!loadingStatus">

      <template v-if="patterns.length > 0">
        <ul class="dashboard-list">

          <li class="dashboard-listItem" v-for="pattern in patterns">
            <router-link :to="{ name: 'preview', params: { patternName: `${pattern}` }}">
              {{ pattern }}
            </router-link>
          </li>

        </ul>
      </template>

      <template v-else-if="patterns.length === 0">
        <p class="dashboard-list--empty">Nothing to review 😄 </p>
      </template>
    </template>

    <template v-else-if="loadingStatus">
      <img src="vendor/workshop/images/loader.gif">
    </template>
  </div>
  
</template>

<script>
  export default {
    name: "StatusList",

    props: [
      'containerClass',
      'patterns',
      'loadingStatus'
    ],

    data() {
      return {

      }
    }

  }
</script>