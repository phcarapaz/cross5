<template>
  <div>
    <h1>{{ userId ? 'Edit' : 'Add' }} User</h1>
    <form @submit.prevent="submitForm">
      <input v-model="form.name" placeholder="Name" required />

      <input v-model="form.email" placeholder="Email" type="email" required />
      <p v-if="emailError" style="color: red">{{ emailError }}</p>

      <input
        v-model="form.password"
        type="password"
        placeholder="Password"
        :required="!userId"
      />
      <p v-if="passwordError" style="color: red">{{ passwordError }}</p>

      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from '../../axios';
import { useRoute, useRouter } from 'vue-router';

const form = ref({ name: '', email: '', password: '' });
const emailError = ref('');
const passwordError = ref('');
const router = useRouter();
const route = useRoute();
const userId = route.params.id;

function doSomething() {
  console.log('Window resized');
}

const fetchUser = async () => {
  try {
    if (!userId) return;
    const { data } = await axios.get(`/users/${userId}`);
    form.value = { ...data, password: '' }; // ไม่โหลดรหัสผ่านเก่า
  } catch (error) {
    console.error('Fetch user error:', error);
  }
};

// ✅ Validate ก่อนส่งฟอร์ม
const validateForm = () => {
  emailError.value = '';
  passwordError.value = '';

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  let isValid = true;

  if (!emailPattern.test(form.value.email)) {
    emailError.value = 'อีเมลไม่ถูกต้อง';
    isValid = false;
  }

  if (!userId && form.value.password.length < 6) {
    passwordError.value = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
    isValid = false;
  }

  return isValid;
};

const submitForm = async () => {
  if (!validateForm()) return;

  try {
    if (userId) {
      await axios.put(`/users/${userId}`, form.value);
    } else {
      await axios.post('/users', form.value);
    }
    router.push('/');
  } catch (error) {
    console.error('Submit form error:', error);
  }
};

onMounted(() => {
  if (userId) fetchUser();
  window.addEventListener('resize', doSomething);
});

onUnmounted(() => {
  window.removeEventListener('resize', doSomething);
});
</script>
