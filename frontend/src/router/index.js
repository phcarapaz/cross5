// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import UserList from '@/components/views/UserList.vue'
import UserForm from '@/components/views/UserForm.vue'

const routes = [
  { path: '/', component: UserList },
  { path: '/add', component: UserForm },
  { path: '/edit/:id', component: UserForm, props: true },
  { path: '/delete/:id', component: UserForm, props: true },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
