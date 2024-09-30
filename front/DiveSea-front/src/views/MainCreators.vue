<script setup>
  import MainAuthorCard from '@/components/MainAuthorCard.vue'
  import { useNftStore } from '@/stores/Nft'
  import { storeToRefs } from 'pinia'
  import { onMounted } from 'vue'
  import NftCard from '@/components/NftCard.vue'
  const store = useNftStore()
  const { authors, isLoading } = storeToRefs(store)
  // Вызов функции при монтировании компонента
  onMounted(() => {
    store.getAuthors();
  });
</script>

<template>
  <section class="creators">
    <div class="container creators__container">
      <h1 class="main-title creators__title">Creators</h1>

      <div class="creators__content">
        <div class="loader product-detail__loader" v-if="!authors === 0 ? isLoading = true : isLoading = false"></div>
        <router-link :to="{ name: 'creators.show', params: {id: card.id} }" class="creators__card" v-for="(card, index) in authors" :key="index">
          <MainAuthorCard :img="card.img" :alt="card.name" :name="card.name" :nickname="card.nickname" followers="33.3k"/>
        </router-link>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
  .creators{
    margin-top: 155px;
    margin-bottom: 200px;
    &__container{
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    &__title{
      margin-bottom: 44px;
    }
    &__content{
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      column-gap: 30px;
      row-gap: 20px;
    }
    &__card{
      grid-column: 3 span;
    }
  }
</style>