import { createApp } from 'vue'
import { router } from './router/index.js'
import './style.css'
import App from './App.vue'

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !localStorage.getItem('accessToken')) {
        next('/');
    } else {
        next();
    }
});

createApp(App)
    .use(router)
    . mount('#app')
