<template>
	<div>
		<h2>Listado de Productos</h2>
		<p>A continuación puede ver todos nuestros productos.</p>

		<div v-if="!isLoading">
			<div class="col-md-4 pb-2">
				<button v-b-modal.modal1 type="button" class="btn btn-outline-success btn-sm" v-if="isType == 'admin'">
					Agregar producto
				</button>
			</div>
			<table class="ProductsPage-listado">
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Marca</th>
					<th>Categoria</th>
					<th v-if="isType == 'admin'">Acciones</th>
				</tr>
				<!--<tr>
					<td>{{ producto.id_producto }}</td>
					<td>{{ producto.nombre }}</td>
					<td>{{ producto.marca }}</td>
					<td>{{ producto.categoria }}</td>
					<td><router-link :to="'/productos/' + producto.id_producto">Ver</router-link></td>
				</tr>-->
				<ProductListRow v-for="producto in productosDescendentes" :producto="producto"/>
			</table>
			<div>
				<!-- Modal Component -->
				<b-modal ref="myModalRef" id="modal1" title="Agregar producto." hide-footer>
					<input type="hidden" v-model="entryid" />
					<b-form-group
						id="fieldset1"
						label="Nombre del producto"
						label-for="input1"
						:invalid-feedback="invalidFeedback"
						:valid-feedback="validFeedback"
						:state="state"
					>
						<b-form-input id="input1" :state="state" v-model.trim="firstname"></b-form-input>
					</b-form-group>

					<b-form-group
						id="fieldset4"
						label="Descripción"
						label-for="input4"
						:invalid-feedback="invalidFeedback2"
						:valid-feedback="validFeedback2"
						:state="state"
					>
						<b-form-input id="input4" :state="state" v-model.trim="desc"></b-form-input>
					</b-form-group>

					<b-form-group
						id="fieldset5"
						label="Precio"
						label-for="input5"
						:invalid-feedback="invalidFeedback3"
						:valid-feedback="validFeedback3"
						:state="state"
					>
						<b-form-input id="input5" :state="state" v-model.trim="precio"></b-form-input>
					</b-form-group>

					<b-form-group
						id="fieldset2"
						label="Seleccioná la marca"
						label-for="input2"
					>
						<b-form-select v-model.trim="bselected" :options="boptions" class="mb-3" />
					</b-form-group>

					<b-form-group
						id="fieldset3"
						label="Seleccioná la categoría"
						label-for="input3"
					>
						<b-form-select v-model.trim="selected" :options="options" class="mb-3" />
					</b-form-group>
					<b-btn v-if="methodType == 'add'" class="mt-3" variant="outline-success" block @click="saveData">Agregar</b-btn>
					<b-btn v-if="methodType == 'edit'" class="mt-3" variant="outline-success" block @click="updateData">Modificar</b-btn>
				</b-modal>
			</div>
		</div>
		<div v-else>
			<img src="../assets/ajax-loader.gif" alt="">
			Cargando...
		</div>
	</div>
	
</template>


<script>
// Para poder usar un componente, tenemos que primero,
// importarlo. Luego, lo registramos en el componente
// local usando la propiedad "components".
import ProductListRow from './ProductListRow.vue';

export default {
	// Le agregamos el nombre del componente. Debería ser el
	// mismo del archivo.
	name: 'ProductsPage',
	// Registramos los componentes que utilizamos.
	components: {
		// Abreviación de:
		// ProductListRow: ProductListRow
		ProductListRow
	},
	data: function() {
		return {
			entryid : null,
			methodType : 'add',
			selected: null,
			bselected : null,
			isType : localStorage.getItem('isType'),
			firstname : '',
			desc : '',
			precio : '',
			brand : null,
			category : '',
			options: [
				{ value: null, text: 'Seleccione la marca' }
			],
			boptions: [
				{ value: null, text: 'Seleccione la categoría' }
			]
			//productos: []
		}
	},
	computed: {
		state () {
			return this.firstname.length >= 4 ? true : false
		},
		invalidFeedback () {
			if (this.firstname.length > 4) {
				return ''
			} else if (this.firstname.length > 0) {
				return 'El producto debe contener mas de 4 caracteres'
			} else {
				return 'Por favor ingrese el nombre del producto'
			}
		},
		state () {
			return this.desc.length >= 10 ? true : false
		},
		invalidFeedback2 () {
			if (this.desc.length > 10) {
				return ''
			} else if (this.desc.length > 0) {
				return 'El desc debe contener mas de 10 caracteres'
			} else {
				return 'Por favor ingrese la descripción del producto'
			}
		},
		state () {
			return this.desc.length >= 10 ? true : false
		},
		productosDescendentes: function() {
			// this.$store permite acceder al store de Vuex
			// de la app.
			// Desde el $store, pueden luego acceder al
			// state.
			return this.$store.state.productos.reverse();
			// return this.productos.reverse();
		},
		isLoading() {
			return this.$store.state.loading;
		}
	},
	methods: {
		saveData() {
			var firstname = this.firstname;
			var desc = this.desc;
			var precio = this.precio;
			var brand = this.bselected;
			var category = this.selected;
			if(brand == null || firstname =='' || desc =='' || precio =='' || this.selected === null ){
				return false;
			}
			else{
				this.$store.dispatch('addEntryFromAPI',{
					'firstname' : firstname,
					'desc' : desc,
					'precio' : precio,
					'brand' : brand,
					'category' : category
				})
				.then(response => response.json())
				.then(data => {
					this.$store.dispatch('loadProductsFromAPI');
					this.$refs.myModalRef.hide();
				});
			}
		},
		updateData(){
			var id = this.entryid;
			var firstname = this.firstname;
			var desc = this.desc;
			var precio = this.precio;
			var brand = this.bselected;
			var category = this.selected;
			if(brand == null || firstname =='' || desc =='' || precio =='' || this.selected === null ){
				return false;
			}
			else{
				this.$store.dispatch('updateEntryFromAPI',{
					'id' : id,
					'firstname' : firstname,
					'desc' : desc,
					'precio' : precio,
					'brand' : brand,
					'category' : category
				})
				.then(response => response.json())
				.then(data => {
					if(data.status == '1'){
						this.$store.dispatch('loadProductsFromAPI');
					}
					
					this.$refs.myModalRef.hide();
				});
			}
		}
	},
	mounted() {
		// Como ahora el php lo accedemos en un servidor
		// diferente, vamos a necesitar setearle el CORS.
		/*fetch('http://localhost/santiago/api/productos.php')
			.then(respuesta => respuesta.json())
			.then(data => {
				console.log("Data: ", data);
				this.productos = data;
			});*/
		// Despachamos la acción del store para cargar
		// los productos.
		// Recordar que la acción está definida en el
		// "actions" del store.
		//this.isType = localStorage.getItem('isType');
		this.$store.dispatch('loadProductsFromAPI');
		//get category
		this.$store.dispatch('loadCategoryFromAPI',{})
		.then(response => response.json())
		.then(data => {
			data.forEach(element => {
				var item = {};
				item.value = element.id_categoria;
				item.text = element.categoria;
				this.options.push(item);
			});
			// this.productos = data;
		});
		this.$store.dispatch('loadBrandFromAPI',{})
		.then(response => response.json())
		.then(data => {
			data.forEach(element => {
				var item = {};
				item.value = element.id_marca;
				item.text = element.marca;
				this.boptions.push(item);
			});
			// this.productos = data;
		});
	}
}

</script>

<style>
.ProductsPage-listado {
	border: 1px solid #666;
	border-collapse: collapse;
	margin: auto;
}

.ProductsPage-listado th, 
.ProductsPage-listado td {
	padding: 1em;
	border: 1px solid #666;
}
</style>