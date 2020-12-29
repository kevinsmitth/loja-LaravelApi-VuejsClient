import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import SignIn from '../views/SignIn.vue'
import Dashboard from '../views/Dashboard.vue'
import store from '@/store'
import Shop from '../views/Shop.vue'
import Product from '../views/Product.vue'
import Missing from '../views/Missing.vue'
import Cart from '../views/Cart.vue'
import Orders from '../views/Orders.vue'
import OrderItem from '../views/OrderItem.vue'
import ProductImages from '../views/ProductImages.vue'


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {title: 'Bem Vindo a Loja'},
  },
  {
    path: '/signin',
    name: 'signin',
    component: SignIn,
    meta: {title: 'Entrar'},
    beforeEnter: (to, from, next) => {
      if (store.getters['auth/authenticated']) {
        return next({
          name: 'shop'
        })
      }
      
      next();
    }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {title: 'Dashboard'},
    beforeEnter: (to, from, next) => {
      if (!store.getters['auth/authenticated']) {
        return next({
          name: 'signin'
        })
      }
      
      next();
    }
  },
  {
    path: '/shop',
    name: 'shop',
    component: Shop,
    meta: {title: 'Produtos'},

  },

  {
    path: '/shop/:id',
    name: 'product',
    component: Product,
    meta: {title: 'Produto'},

  },

  {
    path: '/order-items/:id',
    name: 'order-item',
    component: OrderItem,
    meta: {title: 'Pedido:id'},

  },

  {
    path: '/cart',
    name: 'cart',
    component: Cart,
    meta: {title: 'Carrinho'},
  },

  {
    path: '/orders',
    name: 'orders',
    component: Orders,
    meta: {title: 'Meus Pedidos'},
  },

  {
    path: '/product-images',
    name: 'product-images',
    component: ProductImages,
    meta: {title: 'Envie Imagens para os Produtos'},
  },



  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },

  {
    path: '*',
    name: '404',
    component: Missing,
    meta: {title: 'Pagina Inexistente'},
  }
]


const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,

})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title

  next()
});

export default router
