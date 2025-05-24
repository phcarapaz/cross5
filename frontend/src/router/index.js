

import UserForm from '@/components/views/UserForm.vue';
import UserList from '@/components/views/UserList.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  { path: '/', component: UserList},
  { path: '/add', component: UserForm} ,
  { path: '/edit/:id', component: UserForm, props: true },
  { path: '/delete/:id', component: UserForm, props: true },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
