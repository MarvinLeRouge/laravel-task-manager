import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../lib/axios'

export const useAuthStore = defineStore('auth', () => {
    const token = ref<string | null>(localStorage.getItem('token'))
    const user = ref<any | null>(null)

    const isAuthenticated = computed(() => !!token.value)

    async function login(email: string, password: string) {
        const response = await api.post('/login', { email, password })
        token.value = response.data.token
        user.value = response.data.user
        localStorage.setItem('token', token.value ?? '')
    }

    async function logout() {
        await api.post('/logout')
        token.value = null
        user.value = null
        localStorage.removeItem('token')
    }

    return { token, user, isAuthenticated, login, logout }
})