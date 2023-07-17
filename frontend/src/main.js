import { createApp } from 'vue'
import { router } from '@/router/index.js'
import { validateToken } from '@/services/api.js'
import '@/assets/styles.css'
import App from '@/App.vue'

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        if (!localStorage.getItem('accessToken')) {
            next('/');
        } else {
            const isValidToken = await validateToken()

            if (isValidToken) {
                next()
            } else {
                next('/')
            }
        }
    } else {
        next()
    }
});

createApp(App)
    .use(router)
    . mount('#app')
