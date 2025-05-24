<template>
  <div>
    <h1>Dashboard</h1>
    <p v-if="message">{{ message }}</p>
    <button @click="logout">Logout</button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      message: ''
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
        const res = await axios.get('http://localhost/backend/index.php/auth/protected_route', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })

        if (res.data.status) {
          this.message = res.data.data
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

<style scoped>
h1 {
  font-size: 24px;
  margin-bottom: 10px;
}
</style>
