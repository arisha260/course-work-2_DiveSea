<script setup>
  import MainCategory from '@/components/MainCategory.vue'
  import NftCard from '@/components/NftCard.vue'
  import MainHollow from '@/components/MainHollow.vue'
  import { useNftStore } from '@/stores/Nft'
  import { storeToRefs } from 'pinia'
  import { onMounted, ref } from 'vue'
  const store = useNftStore()
  const { nfts, hasMore, isLoading, loaderMain } = storeToRefs(store)

  const timeLeft = ref({});

  // Функция для вычисления оставшегося времени
  const calculateTimeLeft = (endTime) => {
    const endDate = new Date(endTime);
    const now = new Date();
    const difference = endDate - now;
    if (difference <= 0) {
      return 'Auction ended';
    }
    const hours = Math.floor(difference / (1000 * 60 * 60));
    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((difference % (1000 * 60)) / 1000);
    return `${hours}h ${minutes}m ${seconds}s`;
  };

  onMounted(() => {
    if (nfts.value.length === 0) {
      store.loadMore();
    }

  // Обновляем таймер каждую секунду
  setInterval(() => {
    nfts.value.forEach((card) => {
      if (card.end_time) {
        timeLeft.value[card.id] = calculateTimeLeft(card.end_time);
      }
    });
  }, 1000);
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
          <keep-alive>
            <router-link :to="{ name: 'discover.show', params: {id: card.id} }" class="discover__card" v-for="(card, index) in nfts" :key="index">
              <NftCard :img="card.img" alt="card1" :title="card.title">
                <template v-slot:nft-card__time v-if="card.end_time">
                  <!-- Отображаем оставшееся время для каждого NFT -->
                  <span class="nft-card__time">{{ timeLeft[card.id] || card.end_time }}</span>
                </template>
                <template v-slot:nft-card__content-bottom>
                  <!-- Проверка данных -->
                  <div v-if="card.sale_type === 'put_on_sale' && card.currentBid" class="nft-card__content-bottom">
                    <div class="nft-card__current-bid">
                      <span>Current bid</span>
                      <p class="nft-card__price nft-card__rate">{{ card.currentBid }}</p>
                    </div>
                    <a href="#"  class="main-button nft-card__btn">PLACE BID</a>
                  </div>
                  <div v-else-if="card.price" class="nft-card__content-bottom">
                    <div class="nft-card__current-bid">
                      <span>Price</span>
                      <p class="nft-card__price">{{ card.price }}</p>
                    </div>
                    <a href="#" class="main-button nft-card__btn">Buy Now</a>
                  </div>
                </template>
              </NftCard>
            </router-link>
          </keep-alive>
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