import {createRouter, createWebHistory} from 'vue-router';
import Login from '../views/public/Login.vue';
import Register from '@/views/public/Register.vue';
import Todos from '../views/protected/Todos.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Login,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
    {
        path: '/todos',
        name: 'Todos',
        component: Todos,
        meta: { requiresAuth: true },
    },
];

export const router = new createRouter({
    history: createWebHistory(),
    routes,
});