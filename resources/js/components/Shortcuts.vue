<template>
  <div class="popUp popUp--shortcuts">

    <div class="popUp-inner a-dropIn">
      <h3>Shortcuts:</h3>
      <p><slot></slot></p>

    </div>

    <div class="darken a-dropIn"></div>

  </div>

</template>

<script>
  export default {
    name: "Shortcuts"

  }
</script>