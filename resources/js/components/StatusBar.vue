<template>

  <div class="statusbar">

    <div class="status-current"

        @click="toggleStatus"

        v-tooltip.top-center="`${title}`"

        :class="{accepted: isDone,
	          toCheck: isReview,
	          rejected: isRejected,
	          wip: isTodo}">

    </div>

    <div class="status-menue a-dropIn" v-if="isActive">

      <ul class="status-list">

        <li class="status-optionWrap" @click="changeStatus('review')">
          <span class="status-option toCheck">
            Review
          </span>
          
        </li>

        <li class="status-optionWrap" @click="changeStatus('rejected')">
          <span class="status-option rejected">
            Rejected  
          </span>
          
        </li>

        <li class="status-optionWrap" @click="changeStatus('done')">
          <span class="status-option accepted">
            Accepted  
          </span>
          
        </li>

      </ul>

    </div>

  </div>

</template>

<script>
  export default {
    name: "StatusBar",

    props: [
      'status'
    ],

    data() {
      return {
        'dropdownName': 'StatusBar::dropdown-status'
      }
    },

    computed: {
      isTodo: function () {
        return this.status === 'todo';
      },

      isReview: function () {
        return this.status === 'review';
      },

      isDone: function () {
        return this.status === 'done';
      },

      isRejected: function () {
        return this.status === 'rejected';
      },

      title: function () {
        return `status: ${this.status}`;
      },

      isActive: function () {
        return this.$store.getters.activeDropdown === this.dropdownName;
      }
    },

    methods: {

      /**
       * Toggle the status dropdown.
       */
      toggleStatus: function () {
        this.$store.dispatch('toggleDropdown', this.dropdownName);
      },

      /**
       * Change the status of the Pattern.
       * @param status
       */
      changeStatus: function (status) {
        this.$emit('update-status', status);
        this.$store.dispatch('toggleDropdown', this.dropdownName);
      }
    }
  }
</script>