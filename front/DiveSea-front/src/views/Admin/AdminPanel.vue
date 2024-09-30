<script setup>
  import AdminSideBar from '@/components/admin/AdminSideBar.vue'
</script>

<template>
  <section class="admin-panel">
    <router-link :to="{ name: 'home' }" class="admin-panel__back">
      <svg width="5" height="10" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39523 0.953926C8.99428 1.55298 8.99428 2.52423 8.39523 3.12328L4.11103 7.40747L8.39523 11.6917C8.99428 12.2907 8.99428 13.262 8.39523 13.861C7.79618 14.4601 6.82493 14.4601 6.22588 13.861L0.857002 8.49215C0.257952 7.8931 0.257952 6.92185 0.857002 6.3228L6.22588 0.953926C6.82493 0.354876 7.79618 0.354876 8.39523 0.953926Z" fill="#23262F" />
      </svg>
      To Home
    </router-link>
    <div class="container-fluid admin-panel__container">
      <div class="admin-panel__side-bar">
        <RouterLink :to="{ name: 'admin-panel' }"><img src="/logo-header.png" alt="Header logo" class="admin-panel__logo" width="53" height="53" /></RouterLink>
        <AdminSideBar />
      </div>
      <div class="admin-panel__content">
        <router-view />
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
.admin-panel{
  margin: 50px 0;
  position: relative;
  &__container{
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    height: 100vh;
  }
  &__side-bar{
    height: 100%;
    grid-column: 2 span;
    display: flex;
    flex-direction: column;
    gap: 50px;
    border-right: 2px solid #ebe9e9;
  }
  &__content{
    grid-column: 10 span;
    display: flex;
    flex-direction: column;
  }
  &__back{
    position: absolute;
    top: 0;
    left: 10px;
    align-self: flex-start;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 14px;
    line-height: 125%;
    color: #000;
  }
}
</style>