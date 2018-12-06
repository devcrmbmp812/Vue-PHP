<template>
	<form class="RegsiterForm" @submit.prevent="attemptRegister()">
        <b-alert variant="danger" :show="show">{{message}}</b-alert>
		<div class="RegisterForm-fila">
			<label for="email">Email</label>
			<input type="email" id="email" v-model="usuario.email">
		</div>
		<div class="RegisterForm-fila">
			<label for="password">Password</label>
			<input type="password" id="password" v-model="usuario.password">
		</div>
        <div class="RegisterForm-nombre">
			<label for="password">nombre</label>
			<input type="text" id="nombre" v-model="usuario.nombre">
		</div>
		<button class="FormRegister-submit">registro</button>
	</form>
</template>

<script>
//import router from '../router';

export default {
	name:'RegsiterForm',
	data() {
		return {
			usuario: {
				email: null,
                password: null,
                nombre: null
            },
            message : '',
            show : false
		};
	},
	methods: {
		attemptRegister() {
			this.$store.dispatch('register', {
				email: this.usuario.email,
                password: this.usuario.password,
                nombre : this.usuario.nombre
			}).then(response => response.json())
			.then(res => {
				var userType = res.type;
				if(res.status == 1) {
					localStorage.setItem('isAuth', "true");
					localStorage.setItem('isType', 'normal');
					localStorage.setItem('currentUser', res.data.nombre);
					this.$router.push('/products');
                }
                if(res.status == 0){
                    this.show = true;
                    this.message = "Este email ya está registrado";
                }
			});
		}
	}
}
</script>

<style>
	
</style>