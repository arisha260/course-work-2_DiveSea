import { createRouter, createWebHistory } from 'vue-router'
// import { useAuthStore } from '@/stores/authStore';
//import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior(to, from, savedPosition) {
    // Если есть сохраненная позиция (например, после нажатия кнопки "Назад")
    if (savedPosition) {
      return savedPosition;
    } else {
      // По умолчанию прокрутка к началу страницы
      return { top: 0 };
    }
  },
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/MainHome.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },

    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/MainAuth.vue'),
      meta: { requiresHeaderFooter: false},
    },
    {
      path: '/admin-panel',
      name: 'admin-panel',
      component: () => import('../views/Admin/AdminPanel.vue'),
      meta: { requiresHeaderFooter: false},
      children: [
        {
          path: '/admin-panel/approval',
          name: 'admin-panel-approval',
          component: () => import('../components/admin/AdminPanelApproval.vue'),
          meta: { requiresHeaderFooter: false},
        },
        {
          path: '/admin-panel/statistics',
          name: 'admin-panel-statistics',
          component: () => import('../components/admin/AdminPanelStatistic.vue'),
          meta: { requiresHeaderFooter: false},
        }
      ]
    },
    {
      path: '/discover',
      name: 'discover',
      component: () => import('../views/MainDiscover.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/creators',
      name: 'creators',
      component: () => import('../views/MainCreators.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/creators/:id',
      name: 'creators.show',
      component: () => import('../views/MainAuthorDetail.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/sell',
      name: 'sell',
      component: () => import('../views/MainSell.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/stats',
      name: 'stats',
      component: () => import('../views/Stats.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/discover/:id',
      name: 'discover.show',
      component: () => import('../views/MainProductDetail.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/user-profile/:user_name',
      name: 'profile',
      component: () => import('../views/MainUserProfile.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },



    // Другие маршруты
      {
        path: '/:pathMatch(.*)*', // перехватывает все несуществующие пути
        name: 'not_found',
        component: () => import('../views/MainNotFound.vue'),
      },
  ]
})

// router.beforeEach(async (to, from, next) => {
//   const authStore = useAuthStore(); // Теперь импортируем хранилище
//
//   // Проверяем, требуется ли авторизация для маршрута
//   if (to.meta.requiresAuth) {
//     // Если пользователь не авторизован, перенаправляем на страницу логина
//     if (!authStore.token) {
//       return next({ name: 'login' });
//     }
//
//     // Проверяем действительность токена
//     try {
//       await authStore.getUser();
//       next();
//     } catch (error) {
//       authStore.clearToken();
//       next({ name: 'login' });
//     }
//   } else {
//     next();
//   }
// });


export default router
