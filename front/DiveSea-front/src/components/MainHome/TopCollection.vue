<script setup>
import MainTable from '@/components/table/MainTable.vue'

</script>

<template>
  <section class="top-collection">
    <div class="container top-collection__container">
      <h1 class="main-title top-collection__title">Top Collection</h1>
      <MainTable />
      <div class="top-collection__explore-all explore-all">
        <span class="explore-all__text">Explore All</span>
        <svg width="17" height="17" viewBox="0 0 17 17" class="explore-all__svg" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.25293 8.35095H15.2177" stroke="currentColor" stroke-width="1.99471" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M8.2334 1.36646L15.2158 8.34884L8.2334 15.3312" stroke="currentColor" stroke-width="1.99471" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
  .top-collection {
    margin-top: 232px;
    margin-bottom: 90px;
    @media (max-width: 1200px) {
      margin-top: 168px;
      margin-bottom: 70px;
    }
    @media (max-width: 800px) {
      margin-top: 70px;
      margin-bottom: 70px;
    }
    &__container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    &__title{
      margin-bottom: 90px;
      @media (max-width: 1200px) {
        margin-bottom: 64px;
      }
    }
    &__explore-all{
      margin-top: 85px;
      @media (max-width: 1200px) {
        margin-top: 60px;
      }
    }
  }
</style>