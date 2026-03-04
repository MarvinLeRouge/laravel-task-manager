<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useCategoryStore } from '../stores/categories'

const store = useCategoryStore()
const name = ref('')
const color = ref('#6366f1')
const editingId = ref<number | null>(null)

onMounted(() => store.fetchCategories())

function startEdit(category: any) {
    editingId.value = category.id
    name.value = category.name
    color.value = category.color
}

function cancelEdit() {
    editingId.value = null
    name.value = ''
    color.value = '#6366f1'
}

async function handleSubmit() {
    if (editingId.value) {
        await store.updateCategory(editingId.value, { name: name.value, color: color.value })
    } else {
        await store.createCategory({ name: name.value, color: color.value })
    }
    cancelEdit()
}
</script>

<template>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-semibold mb-6">Catégories</h1>

        <div class="bg-white shadow rounded p-4 mb-6">
            <h2 class="text-lg font-medium mb-3">{{ editingId ? 'Modifier' : 'Nouvelle catégorie' }}</h2>
            <div class="flex gap-3 items-end">
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">Nom</label>
                    <input v-model="name" type="text" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Couleur</label>
                    <input v-model="color" type="color" class="mt-1 block rounded border-gray-300">
                </div>
                <button @click="handleSubmit" class="bg-indigo-500 text-white px-4 py-2 rounded">
                    {{ editingId ? 'Mettre à jour' : 'Créer' }}
                </button>
                <button v-if="editingId" @click="cancelEdit" class="text-gray-500 px-4 py-2">Annuler</button>
            </div>
        </div>

        <div class="bg-white shadow rounded p-4">
            <div v-for="category in store.categories" :key="category.id"
                class="flex items-center justify-between py-2 border-b">
                <div class="flex items-center gap-3">
                    <span class="w-4 h-4 rounded-full" :style="{ backgroundColor: category.color }"></span>
                    {{ category.name }}
                </div>
                <div class="flex gap-2">
                    <button @click="startEdit(category)" class="text-indigo-500">Éditer</button>
                    <button @click="store.deleteCategory(category.id)" class="text-red-500">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</template>