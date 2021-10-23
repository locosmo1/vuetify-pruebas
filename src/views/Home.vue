<template>
  <hello-world />
</template>

<script>
  import HelloWorld from '../components/HelloWorld'
  import login from '../views/Login'

  export default {
    name: 'Home',

    components: {
      HelloWorld,
      login,
    },
  }
</script>
