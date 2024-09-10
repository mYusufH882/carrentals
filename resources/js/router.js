import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/register',
        name: 'Register',
        component: () => import('./auth/Register.vue')
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('./auth/Login.vue')
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('./layout/Dashboard.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;