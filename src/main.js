// Vamos a observar que todos los archivos de Vue utilizan
// extensamente ES6+, incluyendo la API de módulos.
// La idea con los módulos es que en un archivo de JavaScript,
// podemos exportar una o más estructuras: Variables/
// constantes, funciones/clases, objetos/arrays.
// Luego, podemos en cualquier archivo importar dichos
// elementos, usando la sintaxis de "import".
// Uso básico:
// import NombreDeLaVariableParaAlmacenarElValorImportado from 'ruta-al-archivo-de.js'
// Nota: La ruta del archivo no necesita la extensión.
// Nota 2: La ruta del archivo, cuando estamos usando los 
// 	módulos de npm, puede en vez de ser una ruta propiamente
// 	dicho, ser el nombre del módulo de npm.
import Vue from 'vue' // Este 'vue' no hace referencia a un archivo propiamente dicho, sino al módulo de npm "vue".
import App from './App.vue'
import router from './router' // Acá vemos que obvía la extensión ".js".
import store from './store'
import BootstrapVue from 'bootstrap-vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"

Vue.use(BootstrapVue)

Vue.config.productionTip = false

// Instancia la app de Vue.
new Vue({
  router, // Incluye el router.
  store, // Incluye el store de Vuex.
  // render permite definir una función indicando cómo
  // renderizar el componente.
  // "h" estaría funcionando básicamente como un 
  // createElement. La "h" viene por "HyperScript".
  render: h => h(App)
}).$mount('#app')
