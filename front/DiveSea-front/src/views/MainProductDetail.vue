<script setup>
import { useRoute } from 'vue-router';
import { onMounted, watch, ref } from 'vue';
import { useNftStore } from '@/stores/Nft';
import { storeToRefs } from 'pinia';
import NftCardFromCreator from '@/components/NftCardFromCreator.vue'

const route = useRoute();
const store = useNftStore();
const { nft, isLoading, error, success, authorWorks } = storeToRefs(store); // Берем состояние из Pinia store

const openModal = ref(false); // модалка успешной покупки
const openModalErr = ref(false); // модалка ошибки
const AuctionModalModal = ref(false); // модалка ошибки
const isListVisible = ref(false);

const currentBid = ref(null);

const toggleListVisibility = () => {
  isListVisible.value = !isListVisible.value;
};

const buyNft = async (id) => {
  await store.buyNft(id); // Покупка через Pinia Store
  if (success.value) {
    openModal.value = true; // Успешная покупка
  } else {
    openModalErr.value = true; // Ошибка при покупке
  }
};

const makeAuctionBit = async (id, bidAmount) => {
  await store.makeAuctionBit(id, bidAmount); // Ставка через Pinia Store
  if (success.value) {
    openModal.value = true; // Успешная ставка
  } else {
    console.log('Данные текущей NFT при ошибке', nft.value)
    openModalErr.value = true; // Ошибка при ставке
  }
};



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
            <div class="project-info__end-in" v-if="nft.end_time">
              <span class="main-span">End in</span>
              <p class="project-info__date">{{ nft.end_time }}</p>
            </div>
          </div>

          <a @click="AuctionModalModal = true" class="btn-reset product-detail__btn" v-if="nft.sale_type === 'put_on_sale' && !nft.owner">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
            </svg>
            Place Bid</a>
          <a @click="buyNft(nft.id)" class="btn-reset product-detail__btn" v-else-if="nft.sale_type === 'direct_sale' && !nft.owner">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
            </svg>
            Buy</a>
          <a href="#" class="btn-reset product-detail__btn" v-else>
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
            </svg>
            request buy back</a>
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


      <div class="auction-form popup" v-if="AuctionModalModal">
        <p class="auction-form__text popup__text">
          Make bid on this NFT
        </p>
        <p class="auction-form__text popup__text" @click="toggleListVisibility">how the auction is conducted:
          <svg width="15px" height="15px" class="authorship__svg" :class="{ activeSvg: isListVisible }" viewBox="0 -4.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="0.6"></g><g id="SVGRepo_iconCarrier"><g id="Page-1" stroke="currentColor" stroke-width="1" fill="currentColor" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -6684.000000)" fill="currentColor"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M144,6525.39 L142.594,6524 L133.987,6532.261 L133.069,6531.38 L133.074,6531.385 L125.427,6524.045 L124,6525.414 C126.113,6527.443 132.014,6533.107 133.987,6535 C135.453,6533.594 134.024,6534.965 144,6525.39" id="arrow_down-[#339]"> </path> </g> </g> </g> </g></svg>
        </p>
        <transition name="slide-fade">
          <ol class="authorship__list list" v-if="isListVisible">
            <li class="list__item popup__text">the user cannot place 2 bets in a row</li>
            <li class="list__item popup__text">the amount of the current bet must exceed the previous one by 100</li>
            <li class="list__item popup__text">In case of winning the auction, the amount of the last bid is debited from the user's account, as well as the user becomes the owner of the NFT.</li>
          </ol>
        </transition>
        <form @submit.prevent="makeAuctionBit(nft.id, currentBid)" class="popup__form form">
          <div class="form__content">
            <label class="form__label popup__text" for="bid">Current bid: {{ nft.price }}</label>
            <input type="number" name="bid" class="form__field" id="bid" v-model="currentBid" :placeholder="nft.price" required>
          </div>
          <p class="popup__text popup__warning">*By clicking on the button you confirm your bet</p>
          <button type="submit" class="btn-reset main-button form__btn popup__btn">Make bid</button>
        </form>

      </div>


      <div class="overlay" v-if="openModalErr"></div>

      <div class="sending-status popup" v-if="openModalErr">
        <p class="sending-status__text popup__text">
          Purchase error: {{ error }}
        </p>
        <button @click="openModalErr = false" class="btn-reset main-button sending-status__btn popup__btn">Close</button>
      </div>

      <!-- Modal on success -->
      <div class="overlay" v-if="openModal"></div>
      <div class="sending-status popup" v-if="openModal">
        <p class="sending-status__text popup__text">
          NFT has been successfully acquired! The purchased NFT will appear in your profile.
        </p>
        <router-link :to="{ name: 'home' }">
          <button class="btn-reset main-button sending-status__btn popup__btn">Accept and close</button>
        </router-link>
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

  .popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 300px;
    padding: 25px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 20px;
    border-radius: 31px;
    box-shadow: 0 82px 82px -61px rgba(15, 15, 15, 0.1), 0 -82px 80px 0 rgba(0, 0, 0, 0.05);
    background: #ffffff;
    z-index: 1000000;
    &__text {
      margin: 0;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 16px;
      line-height: 125%;
      color: #000;
    }
    &__btn {
      max-width: 100%;
      padding: 20px;
    }
    &__link {
      color: #000;
      text-decoration: underline;
    }
    &__warning{
      color: red;
    }
  }

  .auction-form{
    max-width: 500px;
  }

  .form{
    display: flex;
    flex-direction: column;
    gap: 20px;
    &__content{
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    &__field{
      padding: 23px 26px;
      border-radius: 12px;
      background: #efefef;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 13px;
      line-height: 125%;
      color: #000;
      outline: none;
      border: 1px solid #efefef;
      &::-webkit-input-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
      &::-moz-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
      &:-moz-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
      &:-ms-input-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
    }
  }

  /* CSS-анимация */
  .slide-fade-enter-active, .slide-fade-leave-active {
    transition: all 0.3s ease;
  }

  .slide-fade-enter, .slide-fade-leave-to /* .slide-fade-leave-active in Vue 3 */ {
    opacity: 0;
    transform: translateY(-10px); /* Начальная/конечная позиция */
  }
</style>