<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/products">Productos</router-link> |
      <router-link to="/about">Sobre la celiaquía</router-link> |
      <!-- <router-link v-if="isLoggedIn"  :to="to" @click.native="logout()">Logout</router-link>  -->
      <router-link v-if="!isLoggedIn" to="/login">Login</router-link> 
      <a href="javascript:;" v-else @click.prevent="logout">Desloguearse</a>
      <span> | Usuario: {{loggedInUser}}</span>
    </div>
    <router-view/>
  </div>
</template>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
}
  
#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>

<script>
export default{
  data() {
    return {
      isLoggedIn : localStorage.getItem('isAuth'),
      isAdmin : localStorage.getItem('isType'),
      loggedInUser : localStorage.getItem('currentUser')
    }
  },
  methods : {
    logout() {
      localStorage.removeItem('isAuth');
      localStorage.removeItem('isType');
      localStorage.removeItem('currentUser');
      this.isLoggedIn = false;
      this.$router.push('/login');
    }
  },
  watch:{
    $route (to, from){
      this.isLoggedIn = localStorage.getItem('isAuth');
      this.isAdmin = localStorage.getItem('isType');
      this.loggedInUser = localStorage.getItem('currentUser');
    }
  }
}
</script>