import {createRouter, createWebHistory} from 'vue-router';
import Login from '../views/public/Login.vue';
import Todos from '../views/protected/Todos.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Login,
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