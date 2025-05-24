// src/axios.js
import axios from 'axios'

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL, 
  headers: {
    'Content-Type': 'application/json',
  },
  timeout: 10000,
})

// Interceptor สำหรับการจัดการ response error
apiClient.interceptors.response.use(
  response => response,
  error => {
    if (error.response) {
      console.error('API Error:', error.response.status, error.response.data)
    } else if (error.request) {
      console.error('No response received from API')
    } else {
      console.error('Axios error:', error.message)
    }
    return Promise.reject(error)
  }
)

export default apiClient
