<template>
  <!--<div>-->
    <!--<h1>An example component.</h1>-->
    <!--<p>See an example how our components are structured.</p>-->
  <!--</div>-->
</template>

<script>
  /*
 * Imports
 */
  import LOG from '../logger';

  export default {

    /**
     * Name of the Component in PascalCase
     */
    name: "ExampleComponent",

    /**
     * Properties that are passed to this component.
     */
    props: [],

    /**
     * Data definition of this component.
     * @returns {{}}
     */
    data() {
      return {
        //
      }
    },

    /**
     * Computed values
     */
    computed: {
      //
    },

    /**
     * Methods (actions)
     */
    methods: {
      //
    },

    /**
     * Watchers to trigger actions, if a watched variable changes.
     */
    watch: {
      //
    },

    /**
     * Navigation guards (by vue-router)
     */
    beforeRouteEnter (to, from, next) {
      // called before the route that renders this component is confirmed.
      // does NOT have access to `this` component instance,
      // because it has not been created yet when this guard is called!
    },
    beforeRouteUpdate (to, from, next) {
      // called when the route that renders this component has changed,
      // but this component is reused in the new route.
      // For example, for a route with dynamic params `/foo/:id`, when we
      // navigate between `/foo/1` and `/foo/2`, the same `Foo` component instance
      // will be reused, and this hook will be called when that happens.
      // has access to `this` component instance.
    },
    beforeRouteLeave (to, from, next) {
      // called when the route that renders this component is about to
      // be navigated away from.
      // has access to `this` component instance.
    },

    /**
     * Default vuejs lifecycle hooks
     */
    beforeCreate() {
      LOG.debug('beforeCreate');
    },

    created() {
      LOG.debug('created');
    },

    beforeMount() {
      LOG.debug('beforeMount');
    },

    mounted() {
      LOG.debug('mounted');
    },

    beforeUpdate() {
      LOG.debug('beforeUpdate');
    },

    updated() {
      LOG.debug('updated');
    },

    beforeDestroy() {
      LOG.debug('beforeDestroy');
    },

    destroyed() {
      LOG.debug('destroyed');
    }
  }
</script>