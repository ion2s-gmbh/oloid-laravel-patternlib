<template>

  <div class="statusbar">

    <div class="status-current"

         @click="isActive = !isActive"

         :title="title"

         :class="{accepted: isAccepted,
	          toCheck: isToCheck,
	          rejected: isRejected,
	          wip: isTodo}">

    </div>

    <div class="status-menue a-dropIn" v-if="isActive">

      <ul class="status-list">

        <li class="status-option toCheck" @click="changeStatus('review')">
          Unreviewed
        </li>

        <li class="status-option rejected" @click="changeStatus('rejected')">
          Rejected
        </li>

        <li class="status-option accepted" @click="changeStatus('done')">
          Accepted
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
        isActive: false
      }
    },

    methods: {
      /**
       * Change the status of the Pattern.
       * @param status
       */
      changeStatus: function (status) {
        this.$emit('update-status', status);
        this.isActive = false;
      }
    },

    computed: {
      isTodo: function () {
        return this.status === 'todo';
      },

      isToCheck: function () {
        return this.status === 'review';
      },

      isAccepted: function () {
        return this.status === 'done';
      },

      isRejected: function () {
        return this.status === 'rejected';
      },

      title: function () {
        return `status: ${this.status}`;
      }
    }
  }
</script>