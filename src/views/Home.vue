<template>
  <div>
    <login></login>
  </div>
</template>

<!-- aqui va el login -->
<script>
  import login from '../views/Login'

  export default {
    name: 'Home',

    components: {
      login
    },
  }
</script>
