<template>
	<form class="LoginForm" @submit.prevent="attemptLogin()">
		<b-alert variant="danger" :show="show">{{message}}</b-alert>
		<div class="LoginForm-fila">
			<label for="email">Email</label>
			<input type="email" id="email" v-model="usuario.email">
		</div>
		<div class="LoginForm-fila">
			<label for="password">Password</label>
			<input type="password" id="password" v-model="usuario.password">
		</div>
		<button class="FormLogin-submit">Ingresar</button>
		<router-link to="/register" class="btn btn-outline-success btn-sm">Register</router-link>
	</form>
</template>

<script>
//import router from '../router';

export default {
	name:'LoginForm',
	data() {
		return {
			usuario: {
				email: null,
				password: null
			},
			show: false,
			message : ''
		};
	},
	methods: {
		attemptLogin() {
			this.$store.dispatch('login', {
				email: this.usuario.email,
				password: this.usuario.password
			}).then(response => response.json())
			.then(res => {
				var userType = res.type;
				if(res.status == 1) {
					localStorage.setItem('isAuth', "true");
					localStorage.setItem('isType', res.type);
					localStorage.setItem('currentUser', res.data.nombre);
					this.$router.push('/products');
				}
				else{
					this.show = true;
					this.message = res.msg;
				}
			});
		}
	}
}
</script>

<style>
	
</style>