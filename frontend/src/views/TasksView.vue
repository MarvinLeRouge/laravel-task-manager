<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useTaskStore } from '../stores/tasks'
import { useCategoryStore } from '../stores/categories'

const taskStore = useTaskStore()
const categoryStore = useCategoryStore()

const showForm = ref(false)
const editingTask = ref<any | null>(null)

const form = ref({
    title: '',
    description: '',
    category_id: '',
    status: 'todo',
    priority: 'medium',
    due_date: '',
})

const filters = ref({ status: '', priority: '', category_id: '', search: '' })

const statuses: Record<string, string> = { todo: 'À faire', in_progress: 'En cours', done: 'Terminé' }
const priorities: Record<string, string> = { low: 'Basse', medium: 'Moyenne', high: 'Haute' }

onMounted(() => {
    taskStore.fetchTasks()
    categoryStore.fetchCategories()
})

function startCreate() {
    editingTask.value = null
    form.value = { title: '', description: '', category_id: '', status: 'todo', priority: 'medium', due_date: '' }
    showForm.value = true
}

function startEdit(task: any) {
    editingTask.value = task
    form.value = { ...task, category_id: task.category?.id ?? '' }
    showForm.value = true
}

const errors = ref<Record<string, string[]>>({})

async function handleSubmit() {
    errors.value = {}
    try {
        if (editingTask.value) {
            await taskStore.updateTask(editingTask.value.id, form.value)
        } else {
            await taskStore.createTask(form.value)
        }
        showForm.value = false
    } catch (e: any) {
        errors.value = e
    }
}

function applyFilters() {
    taskStore.fetchTasks(filters.value)
}
</script>

<template>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Tâches</h1>
            <button @click="startCreate" class="bg-indigo-500 text-white px-4 py-2 rounded">Nouvelle tâche</button>
        </div>

        <!-- Filtres -->
        <div class="bg-white shadow rounded p-4 mb-4 flex flex-wrap gap-3">
            <input v-model="filters.search" type="text" placeholder="Rechercher..." class="rounded border-gray-300 shadow-sm text-sm">
            <select v-model="filters.status" class="rounded border-gray-300 shadow-sm text-sm">
                <option value="">Tous les statuts</option>
                <option v-for="(label, value) in statuses" :key="value" :value="value">{{ label }}</option>
            </select>
            <select v-model="filters.priority" class="rounded border-gray-300 shadow-sm text-sm">
                <option value="">Toutes les priorités</option>
                <option v-for="(label, value) in priorities" :key="value" :value="value">{{ label }}</option>
            </select>
            <select v-model="filters.category_id" class="rounded border-gray-300 shadow-sm text-sm">
                <option value="">Toutes les catégories</option>
                <option v-for="cat in categoryStore.categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
            <button @click="applyFilters" class="bg-indigo-500 text-white px-3 py-1 rounded text-sm">Filtrer</button>
            <button @click="filters = { status: '', priority: '', category_id: '', search: '' }; applyFilters()" class="text-gray-500 text-sm">Réinitialiser</button>
        </div>

        <!-- Formulaire -->
        <div v-if="showForm" class="bg-white shadow rounded p-4 mb-4">
            <h2 class="text-lg font-medium mb-3">{{ editingTask ? 'Modifier' : 'Nouvelle tâche' }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm text-gray-700">Titre</label>
                    <input v-model="form.title" type="text" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title[0] }}</p>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm text-gray-700">Description</label>
                    <textarea v-model="form.description" class="mt-1 block w-full rounded border-gray-300 shadow-sm"></textarea>
                    <p v-if="errors.description" class="text-red-500 text-sm">{{ errors.description[0] }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Statut</label>
                    <select v-model="form.status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option v-for="(label, value) in statuses" :key="value" :value="value">{{ label }}</option>
                    </select>
                    <p v-if="errors.status" class="text-red-500 text-sm">{{ errors.status[0] }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Priorité</label>
                    <select v-model="form.priority" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option v-for="(label, value) in priorities" :key="value" :value="value">{{ label }}</option>
                    </select>
                    <p v-if="errors.priority" class="text-red-500 text-sm">{{ errors.priority[0] }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Catégorie</label>
                    <select v-model="form.category_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">-- Aucune --</option>
                        <option v-for="cat in categoryStore.categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                    <p v-if="errors.category_id" class="text-red-500 text-sm">{{ errors.category_id[0] }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Date d'échéance</label>
                    <input v-model="form.due_date" type="date" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <p v-if="errors.due_date" class="text-red-500 text-sm">{{ errors.due_date[0] }}</p>
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button @click="handleSubmit" class="bg-indigo-500 text-white px-4 py-2 rounded">
                    {{ editingTask ? 'Mettre à jour' : 'Créer' }}
                </button>
                <button @click="showForm = false" class="text-gray-500 px-4 py-2">Annuler</button>
            </div>
        </div>

        <!-- Liste -->
        <div class="bg-white shadow rounded p-4">
            <div v-if="taskStore.tasks.length === 0" class="text-gray-500">Aucune tâche.</div>
            <div v-for="task in taskStore.tasks" :key="task.id" class="flex items-center justify-between py-2 border-b">
                <div>
                    <span class="font-medium">{{ task.title }}</span>
                    <span v-if="task.category" class="ml-2 text-xs px-2 py-1 rounded-full text-white"
                        :style="{ backgroundColor: task.category.color }">
                        {{ task.category.name }}
                    </span>
                    <span class="ml-2 text-xs text-gray-500">{{ statuses[task.status] }} · {{ priorities[task.priority] }}</span>
                </div>
                <div class="flex gap-2">
                    <button @click="startEdit(task)" class="text-indigo-500">Éditer</button>
                    <button @click="taskStore.deleteTask(task.id)" class="text-red-500">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</template>