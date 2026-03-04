<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const email = ref('')
const password = ref('')
const error = ref('')

async function handleLogin() {
    try {
        await auth.login(email.value, password.value)
        router.push({ name: 'tasks' })
    } catch {
        error.value = 'Email ou mot de passe incorrect.'
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow w-full max-w-md">
            <h1 class="text-2xl font-semibold mb-6">Connexion</h1>
            <p v-if="error" class="text-red-500 text-sm mb-4">{{ error }}</p>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="email" type="email" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input v-model="password" type="password" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <button @click="handleLogin" class="w-full bg-indigo-500 text-white py-2 rounded">Se connecter</button>
        </div>
    </div>
</template>