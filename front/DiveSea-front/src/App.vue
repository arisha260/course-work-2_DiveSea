<script setup>
  import { RouterView, useRoute } from 'vue-router'
  import MainHeader from './components/MainHeader.vue'
  import MainFooter from './components/MainFooter.vue'
  import { onMounted } from 'vue';
  import { useAuthStore } from '@/stores/authStore';

  const route = useRoute();
  const authStore = useAuthStore();

  onMounted(async () => {
    // Восстанавливаем данные пользователя из кэша, если он был авторизован
    authStore.getUserFromCache();

    // Если пользователь не авторизован, не делаем запрос на сервер
    if (!authStore.isAuthenticated) {
      console.log('Пользователь не авторизован');
    } else {
      // Если пользователь авторизован, делаем запрос, чтобы убедиться, что сессия действительна
      await authStore.getUser();
      console.log('Пользователь авторизован', authStore.user);
    }
  });
</script>

<template>
  <div class="page__body">
    <MainHeader v-if="route.meta.requiresHeaderFooter" />
    <RouterView />
    <MainFooter v-if="route.meta.requiresHeaderFooter" />
  </div>
</template>

<style scoped>

</style>
