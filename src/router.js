import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import ProductsPage from './components/ProductsPage.vue';
import LoginPage from './components/LoginPage.vue';
import RegisterPage from './components/RegisterPage.vue';

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage
    },
    {
      path: '/register',
      name: 'register',
      component : RegisterPage
    },
    {
      path: '/products',
      name: 'products',
      component: ProductsPage,
      // "meta" es la propiedad que Vue Router utiliza para que podamos
      // agregarle datos arbitrarios a una ruta.
      meta: {
        // Las rutas que requieran autenticación, las vamos a indicar
        // con esta propiedad.
        requiresAuth: true
      }
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    }
  ]
});

// Lógica de verificación de autenticación de las rutas.
// beforeEach se ejecuta antes de cada cambio de ruta.
// Recibe 3 parámetros:
// to: Object. Los datos de la ruta a la que se está queriendo 
//  ingresar.
// from: Object. Los datos de la ruta de la que venimos.
// next: Function. Función que indica a que ruta ir.
// SIEMPRE debemos llamar al next() en el beforeEach.
router.beforeEach((to, from, next) => {
  // Preguntamos si la ruta a la que vamos (to) requiere autenticación.
  // to.matched.some permite ejecutar una función que verifique alguna
  // condición, y retorna true si la condición se cumple.
  // Como está la condición, básicamente pregunta si la ruta tiene 
  // la propiedad "meta.requiresAuth" en true.
  if(to.matched.some(routeData => routeData.meta.requiresAuth)) {
    // Preguntamos si está autenticado o no.
    if(!localStorage.getItem('isAuth')) {
    //if(window.localStorage.get(auth)){
      // Si no lo está, lo mandamos para login.
      next('/login');
    } else {
      // Si está autenticado, lo dejamos pasar.
      next();
    }
  } else {
    // Si no requiere autenticación, también lo dejamos pasar.
    next();
  }
});

// export es el comando que permite exportar una estructura
// para ser importada en otro archivo.
// "default" indica que es la exportación por defecto.
// new Router(...) es el valor que estamos exportando.
export default router;
