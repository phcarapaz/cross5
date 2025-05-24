<template>
  <div>
    <h1>Users</h1>
    <router-link to="/add">Add User</router-link>
    <ul>
      <li v-for="user in users" :key="user.id">
        {{ user.name }} - {{ user.email }}
        <button @click="edit(user.id)">Edit</button>
        <button @click="remove(user.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../../axios';
import { useRouter } from 'vue-router';

const users = ref([]);
const router = useRouter();

const fetchUsers = async () => {
  const res = await axios.get('/users');
  users.value = res.data;
};

const edit = id => router.push(`/edit/${id}`);

const remove = async id => {
  await axios.delete(`/users/${id}`);
  fetchUsers();
};

onMounted(fetchUsers);
</script>
