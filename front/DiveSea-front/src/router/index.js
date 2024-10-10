import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore';

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
      meta: { requiresHeaderFooter: true, requiresAuth: false },

    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/MainAuth.vue'),
      meta: { requiresHeaderFooter: false},
    },
    {
      path: '/request-for-authorship',
      name: 'authorship',
      component: () => import('../views/RequestForAuthorship.vue'),
      meta: { requiresHeaderFooter: false, requiresAuth: true, requiresRole: ['admin', 'user']},
    },
    {
      path: '/admin-panel',
      name: 'admin-panel',
      component: () => import('../views/Admin/AdminPanel.vue'),
      meta: { requiresHeaderFooter: false, requiresAuth: true, requiresRole: 'admin'},
      children: [
        {
          path: '/admin-panel/approval_NFTs',
          name: 'admin-panel-approval-nfts',
          component: () => import('../components/admin/AdminPanelApproval.vue'),
          meta: { requiresHeaderFooter: false, requiresAuth: true, requiresRole: 'admin'},
        },
        {
          path: '/admin-panel/approval_authorship',
          name: 'admin-panel-approval-authorship',
          component: () => import('../components/admin/AdminPanelApproveAuthorship.vue'),
          meta: { requiresHeaderFooter: false, requiresAuth: true, requiresRole: 'admin'},
        }
      ]
    },
    {
      path: '/discover',
      name: 'discover',
      component: () => import('../views/MainDiscover.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },
    {
      path: '/creators',
      name: 'creators',
      component: () => import('../views/MainCreators.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },
    {
      path: '/creators/:id',
      name: 'creators.show',
      component: () => import('../views/MainAuthorDetail.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },
    {
      path: '/sell',
      name: 'sell',
      component: () => import('../views/MainSell.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },
    {
      path: '/stats',
      name: 'stats',
      component: () => import('../views/Stats.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },
    {
      path: '/discover/:id',
      name: 'discover.show',
      component: () => import('../views/MainProductDetail.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },
    {
      path: '/user-profile/:user_name',
      name: 'profile',
      component: () => import('../views/MainUserProfile.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/user-profile/edit/:user_name',
      name: 'profile_edit',
      component: () => import('../views/MainUserProfileChange.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: true },
    },
    {
      path: '/cookie',
      name: 'cookie',
      component: () => import('../views/MainCookie.vue'),
      meta: { requiresHeaderFooter: true, requiresAuth: false },
    },



    // Другие маршруты
      {
        path: '/:pathMatch(.*)*', // перехватывает все несуществующие пути
        name: 'not_found',
        component: () => import('../views/MainNotFound.vue'),
      },
  ]
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  // Загружаем данные пользователя, если не загружены
  await authStore.getUserFromCache();
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    // Если страница требует авторизацию, но пользователь не авторизован, перенаправляем на логин
    return next({ name: 'login' });
  }
  if (to.meta.requiresRole) {
    const userRole = authStore.user?.role;  // Получаем роль пользователя
    const allowedRoles = Array.isArray(to.meta.requiresRole) ? to.meta.requiresRole : [to.meta.requiresRole];
    if (!allowedRoles.includes(userRole)) {
      // Если роль пользователя не соответствует ни одной из разрешенных, перенаправляем на 404
      return next({ name: 'not_found' });
    }
  }
  next(); // Разрешаем переход, если все проверки пройдены
});



export default router
