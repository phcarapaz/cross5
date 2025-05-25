// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import UserList from '@/components/views/UserList.vue'
import UserForm from '@/components/views/UserForm.vue'
import Dashboard from '@/components/views/Dashboard.vue'
import LoginForm from '@/components/views/LoginForm.vue'

const routes = [
  { path: '/', component: UserList ,meta: { requiresAuth: true }},
  { path: '/add', component: UserForm  },
  { path: '/edit/:id', component: UserForm, props: true  },
  { path: '/delete/:id', component: UserForm, props: true },
  { path: '/login', component: LoginForm },
  { path: '/dashboard', component: Dashboard ,meta: { requiresAuth: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const token = localStorage.getItem('token')

  if (requiresAuth && !token) {
    next('/login') // ถ้าไม่มี token ให้ไปหน้า login
  } else {
    next() // ผ่านได้
  }
})
export default router
