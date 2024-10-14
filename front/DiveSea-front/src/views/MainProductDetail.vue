<script setup>
import { useRoute } from 'vue-router';
import { onMounted, watch, ref, onBeforeUnmount } from 'vue'
import { useNftStore } from '@/stores/Nft';
import { useAuthStore } from '@/stores/authStore.js';
import { storeToRefs } from 'pinia';
import NftCardFromCreator from '@/components/NftCardFromCreator.vue'

const route = useRoute();
const store = useNftStore();
const AuthStore = useAuthStore();
const { nft, isLoading, error, success, authorWorks } = storeToRefs(store); // Берем состояние из Pinia store
const { user } = storeToRefs(AuthStore);

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

const closeAuctionBit = async () => {
  AuctionModalModal.value = false;
}

// const handleClickOutside = (event) => {
//   const popup = document.querySelector('.popup');
//   if (!popup && !popup.contains(event.target)) {
//     closeAuctionBit;
//   }
// };

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
              <img :src="nft.author.img" class="project-info__user-avatar" alt="author" width="67" height="67">
              <div class="project-info__text-container">
                <span class="main-span">Created by</span>
                <p class="project-info__text">{{ nft.author.name }}</p>
              </div>
            </div>
            <div class="project-info__owner" v-if="nft.owner">
              <img :src="nft.owner.img" class="project-info__user-avatar" alt="owner" width="67" height="67">
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
            <div class="project-info__end-in" v-if="nft.end_time && nft.sale_type === 'put_on_sale'">
              <span class="main-span">End in</span>
              <p class="project-info__date">{{ nft.end_time }}</p>
            </div>
          </div>


          <router-link :to="{ name: 'login' }" v-if="!user" class="btn-reset product-detail__btn">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
              </svg>
            </svg>
            Register
          </router-link>

          <a v-else-if="nft.sale_type === 'put_on_sale' && !nft.owner && nft.status === 'active'"
             @click="AuctionModalModal = true"
             class="btn-reset product-detail__btn">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
              </svg>
            </svg>
            Place Bid
          </a>

          <a v-else-if="nft.sale_type === 'put_on_sale' && nft.status === 'pending_payment' && nft.current_bid_user_id.id === user.id"
             @click="buyNft(nft.id)"
             class="btn-reset product-detail__btn">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
              </svg>
            </svg>
            Buy
          </a>

          <p class="project-info__text" v-else-if="nft.sale_type === 'put_on_sale' && nft.status === 'pending_payment' && nft.current_bid_user_id.id !== user.id">
            Awaiting payment from the auction winner.
          </p>

          <a v-else-if="nft.sale_type === 'direct_sale' && !nft.owner"
             @click="buyNft(nft.id)"
             class="btn-reset product-detail__btn">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.739747 3.10639C0.739747 2.3746 1.02399 1.67278 1.52995 1.15533C2.0359 0.637871 2.72213 0.347168 3.43766 0.347168H16.6819C17.3975 0.347168 18.0837 0.637871 18.5897 1.15533C19.0956 1.67278 19.3799 2.3746 19.3799 3.10639V4.36861C20.3111 4.43225 21.1839 4.85549 21.8214 5.55262C22.459 6.24974 22.8136 7.16863 22.8136 8.12317V18.6584C22.8136 19.6563 22.426 20.6133 21.736 21.3189C21.0461 22.0246 20.1103 22.421 19.1346 22.421H4.42264C3.44692 22.421 2.51116 22.0246 1.82122 21.3189C1.13128 20.6133 0.743672 19.6563 0.743672 18.6584V8.12317H0.739747V3.35723H0.750539C0.743269 3.27383 0.739668 3.19013 0.739747 3.10639ZM17.9083 3.10639C17.9083 2.41408 17.3589 1.8522 16.6819 1.8522H3.43766C3.11242 1.8522 2.8005 1.98434 2.57052 2.21955C2.34054 2.45475 2.21133 2.77376 2.21133 3.10639C2.21133 3.43903 2.34054 3.75804 2.57052 3.99324C2.8005 4.22845 3.11242 4.36059 3.43766 4.36059H17.9083V3.10639ZM16.1914 13.3908C15.9963 13.3908 15.8091 13.4701 15.6711 13.6112C15.5331 13.7523 15.4556 13.9437 15.4556 14.1433C15.4556 14.3429 15.5331 14.5343 15.6711 14.6754C15.8091 14.8165 15.9963 14.8958 16.1914 14.8958H18.6441C18.8392 14.8958 19.0264 14.8165 19.1643 14.6754C19.3023 14.5343 19.3799 14.3429 19.3799 14.1433C19.3799 13.9437 19.3023 13.7523 19.1643 13.6112C19.0264 13.4701 18.8392 13.3908 18.6441 13.3908H16.1914Z" fill="currentColor" />
              </svg>
            </svg>
            Buy
          </a>
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
        <div class="popup__close" @click="closeAuctionBit"><svg fill="currentColor" width="24px" height="24px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5 c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4 C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"></path> </g></svg></div>
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
        <button @click="openModalErr = false; AuctionModalModal = false" class="btn-reset main-button sending-status__btn popup__btn">Close</button>
      </div>

      <!-- Modal on success -->
      <div class="overlay" v-if="openModal"></div>
      <div class="sending-status popup" v-if="openModal">
        <p class="sending-status__text popup__text">
          NFT has been successfully acquired! The purchased NFT will appear in your profile.
        </p>
        <router-link :to="{ name: 'discover' }" @click.prevent="store.loadMore">
          <button class="btn-reset main-button sending-status__btn popup__btn">Accept and close</button>
        </router-link>
      </div>

    </div>
  </section>
</template>

<style scoped lang="scss">
  .product-detail{
    margin: 150px 0 160px 0;
    @media (max-width: 1200px) {
      margin: 103px 0 119px 0;
    }
    &__container{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      @media (max-width: 960px) {
        align-items: flex-start;
      }
    }
    &__header{
      margin-bottom: 60px;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 35px;
      @media (max-width: 1200px) {
        margin-bottom: 42px;
        gap: 24px;
      }
    }
    &__back-icon{
      @media (max-width: 1200px) {
        width: 26px;
        height: 26px;
      }
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
      @media (max-width: 1200px) {
        font-size: 22px;
      }
    }
    &__loader{
      margin: 100px auto;
      @media (max-width: 1200px) {
        margin: 70px auto;
      }
    }
    &__content{
      padding: 38px;
      border-radius: 24px;
      box-shadow: 18px 18px 61px 0 rgba(0, 0, 0, 0.12);
      background: #fafafa;
      @media (max-width: 1200px) {
        padding: 27px;
        border-radius: 17px;
      }
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
      @media (max-width: 1200px) {
        gap: 11px;
        padding: 17px 0;
        font-size: 13px;
        border-radius: 14px;
      }
      @media (max-width: 490px) {
        font-size: 10px;
      }
      svg{
        @media (max-width: 490px) {
          width: 13px;
          height: 13px;
        }
      }
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
      @media (max-width: 1200px) {
        margin-top: 70px;
      }
    }
  }

  .project-info{
    width: 100%;
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    align-items: center;
    align-self: center;
    @media (max-width: 960px) {
      max-width: 450px;
    }
    @media (max-width: 490px) {
      max-width: 310px;
    }
    &__left{
      grid-column: 6 span;
      @media (max-width: 960px) {
        grid-column: 12 span;
      }
    }
    &__img{
      border-radius: 24px;
      @media (max-width: 1200px) {
        width: 401px;
        height: 398px;
        border-radius: 17px;
      }
      @media (max-width: 490px) {
        width: 279px;
        height: 245px;
      }
      //@media (max-width: 960px) {
      //  width: 279px;
      //  height: 245px;
      //}
    }
    &__right{
      grid-column: 8/5 span;
      @media (max-width: 1200px) {
        grid-column: 7/6 span;
      }
      @media (max-width: 960px) {
        margin-top: 30px;
        grid-column: 12 span;
      }
    }
    &__title{
      margin: 0;
      margin-bottom: 30px;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 51px;
      line-height: 90%;
      color: #292b39;
      @media (max-width: 1200px) {
        font-size: 36px;
      }
      @media (max-width: 490px) {
        font-size: 15px;
      }
    }
    &__descr{
      margin: 0;
      margin-bottom: 70px;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 19px;
      line-height: 153%;
      color: rgba(136, 136, 136, 0.7);
      word-break: break-word;
      @media (max-width: 1200px) {
        font-size: 13px;
        margin-bottom: 50px;
      }
      @media (max-width: 490px) {
        font-size: 13px;
      }
    }
    &__from-whom{
      margin-bottom: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      @media (max-width: 1200px) {
        margin-bottom: 45px;
      }
      @media (max-width: 960px) {
        justify-content: flex-start;
        gap: 30px;
      }
    }
    &__author, &__owner{
      display: flex;
      align-items: center;
      gap: 17px;
      @media (max-width: 1200px) {
        gap: 10px;
      }
      @media (max-width: 490px) {
        flex-direction: column;
        align-items: flex-start;
      }
    }
    &__text{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 20px;
      line-height: 153%;
      color: #000;
      @media (max-width: 1200px) {
        font-size: 18px;
      }
      @media (max-width: 490px) {
        font-size: 13px;
      }
    }
    &__current-end{
      margin-bottom: 55px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      @media (max-width: 1200px) {
        margin-bottom: 38px;
      }
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
      @media (max-width: 1200px) {
        padding-left: 23px;
        font-size: 23px;
      }
      @media (max-width: 490px) {
        font-size: 19px;
      }
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
        @media (max-width: 1200px) {
          background-image: url("/rate-png-1200.png");
          top: 0;
          width: 18px;
          height: 25px;
        }
        @media (max-width: 490px) {
          background-image: url("/rate-png-490.png");
          left: 0;
          width: 13px;
          height: 21px;
        }
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
      @media (max-width: 1200px) {
        font-size: 13px;
      }
      @media (max-width: 490px) {
        font-size: 11px;
      }
    }
    &__user-avatar{
      border-radius: 50%;
    }
  }

  .main-span{
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 17px;
    color: #8d8d8d;
    @media (max-width: 1200px) {
      font-size: 12px;
    }
    @media (max-width: 490px) {
      font-size: 10px;
    }
  }

  .from-creator{
    @media (max-width: 960px) {
      align-self: center;
    }
    &__title{
      margin: 0;
      margin-bottom: 44px;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 31px;
      line-height: 89%;
      color: #c3c3c3;
      @media (max-width: 1200px) {
        margin-bottom: 31px;
        font-size: 22px;
      }
    }
    &__cards{
      display: grid;
      grid-template-columns: repeat(10, 1fr);
      gap: 40px;
      @media (max-width: 960px) {
        gap: 20px;
      }

    }
    &__card{
      grid-column: 2 span;
      @media (max-width: 960px) {
        grid-column: 3 span;
      }
      @media (max-width: 590px) {
        grid-column: 5 span;
      }
      //@media (max-width: 440px) {
      //  grid-column: 10 span;
      //}
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
    &__close{

      position: absolute;
      top: 10px;
      right: 15px;
      padding: 5px;
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