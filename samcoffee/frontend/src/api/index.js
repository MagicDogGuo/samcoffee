import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
})

export const getMenu = () => api.get('/menu')
export const getOrders = () => api.get('/orders')
export const submitOrder = (orderData) => api.post('/orders', orderData)
export const getServerInfo = () => api.get('/health')
