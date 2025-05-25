// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import UserList from '@/components/views/UserList.vue'
import UserForm from '@/components/views/UserForm.vue'
import Login from '@/components/views/Login.vue'
import Dashboard from '@/components/views/Dashboard.vue'

const routes = [
  { path: '/', component: UserList },
  { path: '/add', component: UserForm },
  { path: '/edit/:id', component: UserForm, props: true },
  { path: '/delete/:id', component: UserForm, props: true },
  { path: '/login', component: Login },
  {
    path: '/dashboard',
    component: Dashboard,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token')
      if (token) {
        next()
      } else {
        next('/login')
      }
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
