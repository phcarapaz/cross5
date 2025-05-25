<template>
  <div>
    <h1>Login</h1>
    <input v-model="email" placeholder="Email" />
    <input v-model="password" type="password" placeholder="Password" />
    <button @click="login">Login</button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async login() {
      try {
        const res = await axios.post('http://localhost/login', {
          email: this.email,
          password: this.password
        })
        if (res.data.status) {
          localStorage.setItem('token', res.data.token)
          this.$router.push('/dashboard')
        } else {
          alert('Login failed')
        }
      } catch (e) {
        console.error(e)
      }
    }
  }
}
</script>
