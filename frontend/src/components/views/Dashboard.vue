<template>
  <div>
    <h1>Dashboard</h1>
    <p v-if="message">Message: {{ message }}</p>
    <p v-if="email">Email: {{ email }}</p>
    <p v-if="name">Name: {{ name }}</p>
    <button @click="logout">Logout</button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      message: '',
      email: '',
      name: ''
    }
  },
  mounted() {
    this.fetchProtectedData()
  },
  methods: {
    async fetchProtectedData() {
      const token = localStorage.getItem('token')

      if (!token) {
        this.$router.push('/')
        return
      }

      try {
        const res = await axios.get('http://localhost:8080/api/protected', {
          headers: { Authorization: `Bearer ${token}` }
        })

        if (res.data.status) {
          this.message = res.data.data.message || 'Welcome!'
          this.email = res.data.data.email
          this.name = res.data.data.name
        } else {
          this.message = 'Unauthorized. Redirecting...'
          setTimeout(() => this.$router.push('/'), 1500)
        }
      } catch (err) {
        this.message = 'Error fetching data.'
        console.error(err)
        this.$router.push('/')
      }
    },

    logout() {
      localStorage.removeItem('token')
      this.$router.push('/')
    }
  }
}
</script>
