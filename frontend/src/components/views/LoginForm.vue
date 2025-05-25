<template>
  <div>
    <h1>Login</h1>
    <input v-model="email" placeholder="Email" />
    <input v-model="password" type="password" placeholder="Password" />
    <button @click="login" :disabled="loading">
      {{ loading ? 'Logging in...' : 'Login' }}
    </button>
  </div>
</template>

<script>

import axios from '../../axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false
    }
  },
  methods: {
    async login() {
      this.loading = true
      try {
        const res = await axios.post('http://localhost:8080/api/auth', {
          email: this.email,
          password: this.password
        })
        if (res.data.status) {
          localStorage.setItem('token', res.data.token)
          this.$router.push('/dashboard')
        } else {
          alert(res.data.message || 'Login failed')
        }
      } catch (e) {
        alert('Server error. Please try again.')
        console.error(e)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
