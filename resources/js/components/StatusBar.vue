<template>

  <div class="statusbar">

    <div class="status-current"

         @click="isActive = !isActive"

         title="status: status"

         :class="{accepted: isAccepted,
	          toCheck: isToCheck,
	          rejected: isRejected,
	          wip: isTodo}">

    </div>

    <div class="status-menue a-dropIn" v-if="isActive">

      <ul class="status-list">

        <li class="status-option toCheck" @click="changeStatus('REVIEW')">
          Unreviewed
        </li>

        <li class="status-option rejected" @click="changeStatus('REJECTED')">
          Rejected
        </li>

        <li class="status-option accepted" @click="changeStatus('DONE')">
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
        return this.status === 'TODO'
      },

      isToCheck: function () {
        return this.status === 'REVIEW'
      },

      isAccepted: function () {
        return this.status === 'DONE'
      },

      isRejected: function () {
        return this.status === 'REJECTED'
      }
    }
  }
</script>