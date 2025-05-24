<template>
  <div>
    <h1>Users</h1>
    <router-link to="/add" class="btn">Add User</router-link>

    <table class="user-table">
      <thead>
        <tr>
          <th>ชื่อ</th>
          <th>อีเมล</th>
          <th>จัดการ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            <button @click="edit(user.id)">Edit</button>
            <button @click="remove(user.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
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
  if (!confirm('คุณแน่ใจว่าต้องการลบ?')) return;
  await axios.delete(`/users/${id}`);
  fetchUsers();
};

onMounted(fetchUsers);
</script>

<style scoped>
.user-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 16px;
}
.user-table th,
.user-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}
.user-table th {
  background-color: #f4f4f4;
}
.user-table tr:hover {
  background-color: #f9f9f9;
}
.btn {
  display: inline-block;
  margin-bottom: 12px;
  padding: 6px 12px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}
button {
  margin-right: 6px;
  padding: 4px 8px;
  background-color: #444;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}
button:hover {
  background-color: #666;
}
</style>
