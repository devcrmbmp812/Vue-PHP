<template>
  <div class="home">
    <HelloWorld/>
    <Newsletter/>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '../components/HelloWorld.vue'
import Newsletter from '../components/Newsletter.vue'
export default {
  name: 'home',
  components: {
    HelloWorld,
    Newsletter
  }
}
</script>
