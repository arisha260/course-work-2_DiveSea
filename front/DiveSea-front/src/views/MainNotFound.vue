<script setup>

</script>

<template>
  <section class="not-found">
    <div class="container not-found__container">
      <h1 class="main-title">404! This page not found</h1>
      <router-link :to="{ name: 'home' }" class="not-found__back">Back to home?</router-link>
    </div>
  </section>
</template>

<style scoped lang="scss">
  .not-found{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    &__container{

    }
    &__back{
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 20px;
      line-height: 125%;
      color: #000000;
    }
  }
</style>