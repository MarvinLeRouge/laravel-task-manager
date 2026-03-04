import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import LoginView from '../views/LoginView.vue'
import TasksView from '../views/TasksView.vue'
import CategoriesView from '../views/CategoriesView.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/login', name: 'login', component: LoginView },
        { path: '/tasks', name: 'tasks', component: TasksView, meta: { requiresAuth: true } },
        { path: '/categories', name: 'categories', component: CategoriesView, meta: { requiresAuth: true } },
        { path: '/:pathMatch(.*)*', redirect: '/tasks' },
    ],
})

router.beforeEach((to) => {
    const auth = useAuthStore()
    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        return { name: 'login' }
    }
})

export default router