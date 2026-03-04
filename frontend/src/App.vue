<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuthStore } from './stores/auth'

const auth = useAuthStore()
const router = useRouter()

async function handleLogout() {
    await auth.logout()
    router.push({ name: 'login' })
}
</script>

<template>
    <div>
        <nav v-if="auth.isAuthenticated" class="bg-white shadow px-6 py-3 flex justify-between items-center">
            <div class="flex gap-4">
                <router-link to="/tasks" class="text-indigo-500 font-medium">Tâches</router-link>
                <router-link to="/categories" class="text-indigo-500 font-medium">Catégories</router-link>
            </div>
            <button @click="handleLogout" class="text-gray-500 text-sm">Déconnexion</button>
        </nav>
        <router-view />
    </div>
</template>