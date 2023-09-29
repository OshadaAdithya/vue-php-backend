import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AboutView from '../views/AboutView.vue'
import ToDo from '../views/ToDo.vue'
import NotFound from '../views/NotFound.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      //component: () => import('../views/AboutView.vue')
      component: AboutView
    },
    {
      path: '/todos',
      name: 'todos',
      component: ToDo
    },

    //catch all not found pages
    {
      path: '/:catchAll(.*)',
      name: 'notfound',
      component: NotFound

    }
  ]
})

export default router
