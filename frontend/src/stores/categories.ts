import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../lib/axios'

export const useCategoryStore = defineStore('categories', () => {
    const categories = ref<any[]>([])

    async function fetchCategories() {
        const response = await api.get('/categories')
        categories.value = response.data.data
    }

    async function createCategory(data: any) {
        const response = await api.post('/categories', data)
        categories.value.push(response.data.data)
    }

    async function updateCategory(id: number, data: any) {
        const response = await api.put(`/categories/${id}`, data)
        const index = categories.value.findIndex(c => c.id === id)
        if (index !== -1) categories.value[index] = response.data.data
    }

    async function deleteCategory(id: number) {
        await api.delete(`/categories/${id}`)
        categories.value = categories.value.filter(c => c.id !== id)
    }

    return { categories, fetchCategories, createCategory, updateCategory, deleteCategory }
})