<template>
	<div class="LoginPage">
		<h1>Iniciar Sesión</h1>

		<LoginForm />
	</div>
</template>

<script>
import LoginForm from './LoginForm.vue';

export default {
	name:'LoginPage',
	components: {
		LoginForm
	}
}
</script>

<style>
	
</style>