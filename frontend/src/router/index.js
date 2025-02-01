import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: '',
      component: import('../views/HomeView.vue'),
    },
    {
      path: '/teams/',
      name: 'teams',
      component: import('../views/TeamsView.vue'),
    },
    {
      path: '/leagues/',
      name: 'leagues',
      component: import('../views/LeaguesView.vue'),
    },
    {
      path: '/team/:id',
      name: 'team',
      component: import('../views/TeamView.vue'),
    },
  ],
})

export default router
