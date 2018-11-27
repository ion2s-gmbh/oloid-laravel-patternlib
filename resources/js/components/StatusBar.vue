<template>

	<div class="statusbar">

	<!-- TODO: fill in real status please in title please. -->

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
	  
		  <li class="status-option toCheck" @click="isToCheck = !isToCheck">
		    Unreviewed
		  </li>

		  <li class="status-option rejected" @click="isRejected = !isRejected">
		    Rejected
		  </li>

		  <li class="status-option accepted" @click="isAccepted = !isAccepted">
		    Accepted
		  </li>

		 </ul>

	</div> 

	</div>

</template>

<script>
	export default {
	  name: "StatusBar",
	  data() {
	    return {
	    	isTodo: true,
	    	isToCheck: false,
      		isAccepted: false,
      		isRejected: false,

      		isActive: false

	    }
	  },
	  methods: {

	    
	  },
	  props: {
	  	status
	  }
	}
</script>