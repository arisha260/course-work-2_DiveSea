<script setup>
import { useRoute } from 'vue-router';
import { onMounted, watch } from 'vue';
import { useNftStore } from '@/stores/Nft';
import { storeToRefs } from 'pinia';
import NftCardFromCreator from '@/components/NftCardFromCreator.vue'

const route = useRoute();
const store = useNftStore();
const { nft, isLoading, authorWorks } = storeToRefs(store);

onMounted(async () => {
  const nftId = route.params.id;
  await store.showNft(nftId);

  const authorId = nft.value.author.id;
  // console.log(authorWorks.value)
  await store.loadAuthorWorks(authorId);
});

watch(route, async (newRoute) => {
  const nftId = newRoute.params.id;
  await store.showNft(nftId);

  const authorId = nft.value.author.id;
  await store.loadAuthorWorks(authorId);
});
</script>

<template>
  <section class="product-detail">
    <div class="loader product-detail__loader" v-if="nft ? isLoading = false : isLoading = true"></div>
    <div class="container product-detail__container" v-if="!isLoading">
      <div class="product-detail__header">
        <router-link :to="{name: 'discover'}"><svg class="product-detail__back-icon" width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="0.602051" width="36.8151" height="36.8151" rx="18.4076" fill="currentColor" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3952 11.9539C22.9943 12.553 22.9943 13.5242 22.3952 14.1233L18.111 18.4075L22.3952 22.6917C22.9943 23.2907 22.9943 24.262 22.3952 24.861C21.7962 25.4601 20.8249 25.4601 20.2259 24.861L14.857 19.4922C14.258 18.8931 14.258 17.9218 14.857 17.3228L20.2259 11.9539C20.8249 11.3549 21.7962 11.3549 22.3952 11.9539Z" fill="currentColor" />
        </svg></router-link>
        <h3 class="product-detail__title">Product Detail</h3>
      </div>

      <div class="product-detail__content project-info" v-if="nft">
        <div class="project-info__left">
          <img :src="nft.img" class="project-info__img" alt="product detail" width="564" height="560">
        </div>
        <div class="project-info__right">
          <h2 class="project-info__title">Project {{ nft.title }}</h2>
          <p class="project-info__descr">{{ nft.description }}</p>
          <div class="project-info__from-whom">
            <div class="project-info__author">
              <img :src="nft.author.img" alt="author" width="67" height="67">
              <div class="project-info__text-container">
                <span class="main-span">Created by</span>
                <p class="project-info__text">{{ nft.author.name }}</p>
              </div>
            </div>
            <div class="project-info__owner" v-if="nft.owner">
              <img :src="nft.owner.img" alt="owner" width="67" height="67">
              <div class="project-info__text-container">
                <span class="main-span">Owned by</span>
                <p class="project-info__text" >{{ nft.owner.name }}</p>
              </div>
            </div>
            <p class="main-span" v-else>Никому не принадлежит</p>
          </div>
          <div class="project-info__current-end">
            <div class="project-info__current-bid">
              <span class="main-span">Current Bid</span>
              <p class="project-info__rate">{{ nft.price }}</p>
            </div>
            <div class="project-info__end-in">
              <span class="main-span">End in</span>
              <p class="project-info__date">{{ nft.end_time }}</p>
            </div>
          </div>
          <a href="#" class="btn-reset product-detail__btn">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
            </svg>
            Place Bid</a>
        </div>
      </div>

      <div class="product-detail__from-creator from-creator" v-if="authorWorks.length > 1">
        <h1 class="from-creator__title">From Creator</h1>
        <div class="from-creator__cards">
          <div class="loader product-detail__loader" v-if="isLoading"></div>
          <a
            v-for="(card, index) in authorWorks"
            :key="index"
            class="from-creator__card"
          >
            <NftCardFromCreator :img="card.img" alt="card1" :title="card.title" :rate="card.currentBid" :author="card.author.name" likes="200"/>
          </a>
        </div>
      </div>

    </div>
  </section>
</template>

<style scoped lang="scss">
  .product-detail{
    margin: 150px 0 160px 0;
    &__container{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    &__header{
      margin-bottom: 60px;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 35px;
    }
    &__back-icon{
      rect{
        color: #E6E8EC;
        transition: all .2s ease;
      }
      path{
        color: #23262F;
        transition: all .2s ease;
      }
      @media (hover:hover) {
        &:hover rect{
          color: #b3b2b2;
        }
      }
      &:active rect{
        color: #7a7979;
      }
    }
    &__title{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 31px;
      line-height: 89%;
      color: #23262f;
    }
    &__loader{
      margin: 100px auto;
    }
    &__content{
      padding: 38px;
      border-radius: 24px;
      box-shadow: 18px 18px 61px 0 rgba(0, 0, 0, 0.12);
      background: #fafafa;
    }
    &__btn{
      max-width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      padding: 25px 0;
      font-family: var(--font-family);
      font-weight: 700;
      font-size: 18px;
      line-height: 153%;
      color: #fff;
      border-radius: 20px;
      background: #141416;
      &:focus{
        outline: none;
      }
      @media(hover:hover){
        &:hover{
          color: #4a4a4a;
          background: #d3d3d3;
        }
      }
      &:active{
        color: #353535;
        background: #888888;
      }
    }
    &__from-creator{
      margin-top: 130px;
    }
  }

  .project-info{
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    align-items: center;
    &__left{
      grid-column: 6 span;
    }
    &__img{
      border-radius: 24px;
    }
    &__right{
      grid-column: 8/5 span;
    }
    &__title{
      margin: 0;
      margin-bottom: 30px;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 51px;
      line-height: 90%;
      color: #292b39;
    }
    &__descr{
      margin: 0;
      margin-bottom: 70px;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 19px;
      line-height: 153%;
      color: rgba(136, 136, 136, 0.7);
    }
    &__from-whom{
      margin-bottom: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    &__author, &__owner{
      display: flex;
      align-items: center;
      gap: 17px;
    }
    &__text{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 25px;
      line-height: 153%;
      color: #000;
    }
    &__current-end{
      margin-bottom: 55px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    &__current-bid{
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      flex-direction: column;
    }
    &__rate{
      margin: 0;
      padding-left: 31px;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 32px;
      color: #292b39;
      position: relative;
      &::before{
        content: "";
        position: absolute;
        top: 3px;
        left: -5px;
        background-image: url("/rate-png.png");
        background-repeat: no-repeat;
        background-size: cover;
        width: 24px;
        height: 27px;
      }
    }
    &__end-in{
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      flex-direction: column;
    }
    &__date{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 19px;
      line-height: 157%;
      text-align: right;
      color: #000;
    }
  }

  .main-span{
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 17px;
    color: #8d8d8d;
  }

  .from-creator{

    &__title{
      margin: 0;
      margin-bottom: 44px;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 31px;
      line-height: 89%;
      color: #c3c3c3;
    }
    &__cards{
      display: grid;
      grid-template-columns: repeat(10, 1fr);
      gap: 40px;
    }
    &__card{
      grid-column: 2 span;
    }
  }
</style>