import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../lib/axios'

export const useTaskStore = defineStore('tasks', () => {
    const tasks = ref<any[]>([])

    async function fetchTasks(filters = {}) {
        const response = await api.get('/tasks', { params: filters })
        tasks.value = response.data.data
    }

    async function createTask(data: any) {
        const response = await api.post('/tasks', data)
        tasks.value.push(response.data.data)
    }

    async function updateTask(id: number, data: any) {
        const response = await api.put(`/tasks/${id}`, data)
        const index = tasks.value.findIndex(t => t.id === id)
        if (index !== -1) tasks.value[index] = response.data.data
    }

    async function deleteTask(id: number) {
        await api.delete(`/tasks/${id}`)
        tasks.value = tasks.value.filter(t => t.id !== id)
    }

    return { tasks, fetchTasks, createTask, updateTask, deleteTask }
})