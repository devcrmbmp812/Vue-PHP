<template>
	<tr>
		<td>{{ producto.id_producto }}</td>
		<td>{{ producto.nombre }}</td>
		<td>{{ producto.marca }}</td>
		<td>{{ producto.categoria }}</td>
		<td v-if="isType == 'admin'" >
			<button type="button" class="btn btn-outline-success btn-sm" @click="edit(producto.id_producto)">
				Editar
			</button>
			<button type="button" class="btn btn-outline-danger btn-sm" @click="pdelete(producto.id_producto)">
				Eliminar
			</button>
		</td>
	</tr>
</template>

<script>
import ProductList from './ProductsPage.vue';
export default {
	name: 'ProductListRow',
	data(){
		return {
			isType : ""
		}
	},
	mounted(){
		this.isType = localStorage.getItem("isType");
	},
	props: {
		// Indicamos que tenemos que recibir una propiedad
		// (atributo en el "HTML") que debe ser un objeto.
		producto: Object
	},
	methods:{
		edit() {
			if(localStorage.getItem('isType') != 'admin'){
				alert("you don't have permisson");
			}
			else{
				this.$store.dispatch('getEntryFromAPI',{
					'id' : this.producto.id_producto
				})
				.then(response => response.json())
				.then(data => {
					console.log(data[0]);
					this.$parent.firstname = data[0].nombre;
					this.$parent.selected = data[0].id_categoria;
					this.$parent.bselected = data[0].id_marca;
					this.$parent.methodType = 'edit';
					this.$parent.entryid = data[0].id_producto;
					this.$parent.$refs.myModalRef.show();
				});
			}
		},
		pdelete(){
			if(localStorage.getItem('isType') != 'admin'){
				alert("you don't have permisson");
			}
			else{
				this.$store.dispatch('deleteEntryFromAPI',{
					'id' : this.producto.id_producto
				})
				.then(response => response.json())
				.then(data => {
					if(data.status == 1)
					this.$store.dispatch('loadProductsFromAPI');
				});
			}
			
		}
	}
}
</script>