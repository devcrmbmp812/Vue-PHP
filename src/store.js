import Vue from 'vue';
import Vuex from 'vuex';
import Router from 'vue-router';

Vue.use(Router);
// Le indicamos a Vue que vamos a trabajar con Vuex.
Vue.use(Vuex);


// Creamos nuestro nuevo Vuex.Store
export default new Vuex.Store({
	// En state definimos, adivinen, sí, el state! :D
	state: {
		productos: [],
		loading: false,
		session: {
			loading: false,
			auth: false,
			user: {
				nombre: null,
				email: null
			},
			status: {
				message: null
			}
		}
	},
	mutations: {
		/** 
		 * Setea los productos al state.
		 *
		 * Toda mutación recibe como primer parámetro, el
		 * state actual.
		 * Opcionalmente, podemos pedir un segundo 
		 * parámetro (lo que llamamos el payload), que
		 * lleva los datos que queremos asignar al state.
		 */
		setProductos(state, nuevosProductos) {
			state.productos = nuevosProductos;
		},
		setLoadingOff(state) {
			state.loading = false;
		},
		setLoadingOn(state) {
			state.loading = true;
		},
		setSessionLoadingOff(state) {
			state.session.loading = false;
		},
		setSessionLoadingOn(state) {
			state.session.loading = true;
		},
		setSessionAuth(state, userData) {
			state.session.auth = true;
			state.session.user.nombre = userData.nombre;
			state.session.user.email = userData.email;
		},
		setSessionLogout(state) {
			state.session.auth = false;
		}
	},
	actions: {
		// Definimos las acciones.
		/**
		 * Carga los productos desde la API vía Ajax.
		 *
		 * Toda acción, recibe por parámetro un objeto con
		 * el "contexto".
		 * Ese contexto, tiene entre otras cosas, el state.
		 * Pero, más importante aún, es que tiene acceso
		 * al método "commit". Lo que permite ejecutar
		 * alguna mutación.
		 */
		loadProductsFromAPI(context) {
			// Commiteamos que se setee el estado de carga.
			//context.commit('setLoadingOn');

			// Realizamos la petición de Ajax.
			fetch('http://localhost/api/api/productos.php')
				.then(respuesta => respuesta.json())
				.then(data => {
					console.log("Data: ", data);
					// this.productos = data;
					// Llamamos a la mutación para asignar
					// los productos.
					// commit recibe entre 1 y 2 parámetros.
					// 1. string. El nombre de la mutación.
					// 2. cualquierCosa. La carga/payload
					//  para la mutación.
					context.commit('setProductos', data);

					// Desactivamos el estado de carga.
					//context.commit('setLoadingOff');
				});
		},
		loadCategoryFromAPI (context,datas){
			// Commiteamos que se setee el estado de carga.
			//context.commit('setLoadingOn');

			// Realizamos la petición de Ajax.
			return fetch('http://localhost/api/api/getcategories.php',{
				method: 'get',
				bory: JSON.stringify(datas)
			});
				
		},
		loadBrandFromAPI(context, datas){
			//context.commit('setLoadingOn');

			// Realizamos la petición de Ajax.
			return fetch('http://localhost/api/api/getbrands.php',{
				method: 'get',
				bory: JSON.stringify(datas)
			});
		},
		addEntryFromAPI (context , datas){
			//context.commit('setLoadingOn');
			return fetch('http://localhost/api/api/addproduct.php',{
				method: 'post',
				body: JSON.stringify(datas)
			});
		},
		addNewsletterFromAPI(context, datas){
			return fetch('http://localhost/api/api/addnewsletter.php',{
				method: 'post',
				body: JSON.stringify(datas)
			});
		},
		updateEntryFromAPI(context, datas){
			return fetch('http://localhost/api/api/updateproduct.php',{
				method: 'post',
				body: JSON.stringify(datas)
			});
		},
		deleteEntryFromAPI(context, datas){
			return fetch('http://localhost/api/api/deleteproduct.php',{
				method: 'post',
				body: JSON.stringify(datas)
			});
		},
		getEntryFromAPI(context, datas){
			return fetch('http://localhost/api/api/getproduct.php',{
				method: 'post',
				body: JSON.stringify(datas)
			});
		},
		login(context, userData) {
			// Seteamos el estado de carga.
			context.commit('setSessionLoadingOn');
			return fetch('http://localhost/api/api/login.php', {
				method: 'post',
				body: JSON.stringify(userData)
			});
		},
		register(context, userData){
			context.commit('setSessionLoadingOn');
			return fetch('http://localhost/api/api/register.php', {
				method: 'post',
				body: JSON.stringify(userData)
			});
		}
	}
})
