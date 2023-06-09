import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/App.vue'
import Stats from '../components/Stats.vue'
// import About from './views/About.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/stats', component: Stats },
]

const router = createRouter({
    history: createWebHistory('/'),
    routes
})

export default router