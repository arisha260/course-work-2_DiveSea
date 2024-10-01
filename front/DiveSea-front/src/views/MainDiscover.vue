<script setup>
  import MainCategory from '@/components/MainCategory.vue'
  import NftCard from '@/components/NftCard.vue'
  import MainHollow from '@/components/MainHollow.vue'
  import { useNftStore } from '@/stores/Nft'
  import { storeToRefs } from 'pinia'
  import { onMounted } from 'vue'
  const store = useNftStore()
  const { nfts, hasMore, isLoading, loaderMain } = storeToRefs(store)
  // Вызов функции при монтировании компонента
  onMounted(() => {
    if (nfts.value.length === 0) {
      store.loadMore();
    }
  });
  const loadMore = store.loadMore;
</script>

<template>
  <keep-alive>
    <section class="discover">
      <div class="container discover__container">
        <h1 class="main-title discover__title">Discover NFTs</h1>
        <MainCategory class="discover__category" />
        <div class="loader sec-loader discover__loader" v-if="loaderMain"></div>
        <MainHollow v-else-if="nfts.length === 0" />
        <div class="discover__content">

          <router-link :to="{ name: 'discover.show', params: {id: card.id} }" class="discover__card" v-for="(card, index) in nfts" :key="index"><NftCard :img="card.img" alt="card1" :title="card.title" :rate="card.currentBid" /> </router-link>
        </div>
        <button v-if="hasMore" @click="loadMore" :disabled="isLoading" class="btn-reset main-button discover__btn">
          Еще
        </button>
        <div class="loader discover__loader" v-if="isLoading"></div>
      </div>
    </section>
  </keep-alive>
</template>

<style scoped lang="scss">
  .discover{
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
    &__category{
      margin-bottom: 100px;
    }
    &__content{
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      align-items: center;
      column-gap: 40px;
      row-gap: 67px;
    }
    &__card{
      grid-column: 3 span;
      height: 100%;
    }
    &__btn{
      margin-top: 100px;
      padding: 10px 20px;
    }
  }
</style>