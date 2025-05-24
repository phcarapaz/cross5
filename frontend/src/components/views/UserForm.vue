<template>
  <div>
    <h1>{{ userId ? 'Edit' : 'Add' }} User</h1>
    <form @submit.prevent="submitForm">
      <input v-model="form.name" placeholder="Name" required />
      <input v-model="form.email" placeholder="Email" required />
      <input v-model="form.password" type="password" placeholder="Password" :required="!userId" />
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../../axios';
import { useRoute, useRouter } from 'vue-router';

const form = ref({ name: '', email: '', password: '' });
const router = useRouter();
const route = useRoute();
const userId = route.params.id;
console.log('userId:', userId);

const fetchUser = async () => {
  const { data } = await axios.get(`/users/${userId}`);
  form.value = { ...data, password: '' };
};

const submitForm = async () => {
  console.log('Submitting form:', form.value);
  if (userId) {
    await axios.put(`/users/${userId}`, form.value);
  } else {
    await axios.post('/users', form.value);
  }
  router.push('/');
};

onMounted(() => {
  window.addEventListener('resize', doSomething);
});
onUnmounted(() => {
  window.removeEventListener('resize', doSomething);
});
</script>
