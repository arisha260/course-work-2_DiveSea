<script setup>
  import MainCategory from '@/components/MainCategory.vue'
  import NftCard from '@/components/NftCard.vue'
  import MainHollow from '@/components/MainHollow.vue'
  import { ref, onMounted } from 'vue';
  import { useNftStore } from '@/stores/Nft'
  import { storeToRefs } from 'pinia'

  const store = useNftStore()
  const { nfts, totalNfts } = storeToRefs(store)
  // Вызов функции при монтировании компонента
  onMounted(() => {
    store.getNft()
  });
</script>

<template>
  <section class="explore-marketplace">
    <div class="container explore-marketplace__container">
      <h1 class="main-title explore-marketplace__title">Explore Marketplace</h1>
      <MainCategory :count="totalNfts" class="explore-marketplace__categories" />
      <div class="explore-marketplace__nft" >
        <MainHollow v-if="nfts.length === 0" />
        <NftCard v-for="(card, index) in nfts" :key="index" class="explore-marketplace__card" :img="card.img" alt="card1" :title="card.title" :rate="card.currentBid"/>
      </div>
      <div class="explore-marketplace__explore-all explore-all">
        <router-link :to="{ name: 'discover' }" class="explore-all__text">Explore All</router-link>
        <svg width="17" height="17" viewBox="0 0 17 17" class="explore-all__svg" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.25293 8.35095H15.2177" stroke="currentColor" stroke-width="1.99471" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M8.2334 1.36646L15.2158 8.34884L8.2334 15.3312" stroke="currentColor" stroke-width="1.99471" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
    </div>
  </section>
</template>

<style lang="scss">
  .explore-marketplace {
    margin-top: 100px;
    &__container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    &__title{
      margin-bottom: 65px;
    }
    &__categories{

    }
    &__nft{
      margin-top: 100px;
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      align-items: center;
      column-gap: 40px;
      row-gap: 67px;
    }
    &__card{
      grid-column: 3 span;
    }
    &__explore-all{
      margin-top: 103px;
    }
  }
</style>