import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import('../views/About.vue')
  },
  {
    path: '/loginprueba',
    name: 'loginprueba',
    component: () => import('../views/loginprueba.vue')
  },
  {
    path: '/Cards',
    name: 'cards',
    component: () => import('../views/Cards.vue')
  },
  {
    path: '/consultas',
    name: 'consultas',
    component: () => import('../views/consultas.vue')
  },
  {
    path: '/Login',
    name: 'Login',
    component: () => import('../views/Login.vue')
  },
  {
    path: '/Dashboard',
    name: 'Dashboard',
    component: () => import('../views/Dashboard.vue')
  },
]

const router = new VueRouter({
  routes
})

export default router
