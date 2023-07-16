import {createRouter, createWebHistory} from 'vue-router';
import Login from '../views/public/Login.vue';
import Login2 from '../views/public/Login2.vue';
import Todos from '../views/protected/Todos.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Login,
    },
    {
        path: '/test',
        name: 'Login2',
        component: Login2,
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