<script setup>
import { useRoute } from 'vue-router';
import { onMounted, ref, watch } from 'vue'
import { useNftStore } from '@/stores/Nft';
import { storeToRefs } from 'pinia';
import MainHollow from '@/components/MainHollow.vue'
import NftCard from '@/components/NftCard.vue'


const route = useRoute();
const store = useNftStore();
const { author, isLoading, authorWorks } = storeToRefs(store);
const activeTab = ref(1);

onMounted(async () => {
  const authorId = route.params.id;
  await store.showAuthor(authorId);

  const authorNftId = route.params.id;
  // console.log(authorWorks.value)
  await store.loadAuthorWorks(authorNftId);
});

watch(route, async (newRoute) => {
  const authorId = newRoute.params.id;
  await store.showAuthor(authorId);

  const authorNftId = route.params.id;
  await store.loadAuthorWorks(authorNftId);
});
</script>

<template>
  <section class="author-detail">
    <div class="loader author-detail__loader" v-if="isLoading"></div>
    <div class="container author-detail__container" v-if="!isLoading && author">
      <div class="author-detail__left">
        <div class="author-detail__img-container">
          <img :src="author.img" alt="Автор" class="author-detail__img" width="165" height="165">
          <img src="/check-mark.png" alt="Галочка" class="author-detail__img-mark" width="29px" height="29">
        </div>
        <div class="author-detail__author-info">
          <div class="author-detail__content">
            <p class="author-detail__name" >{{ author.name }}</p>
            <span class="author-detail__nickname">@{{ author.nickname }}</span>
          </div>
          <button class="btn-reset main-button author-detail__btn">Follow +</button>
        </div>

        <div class="author-detail__author-info">
          <div class="author-detail__content">
            <p class="author-detail__count">{{ author.total_sales }} ETH</p>
            <span class="author-detail__what">Total Sales</span>
          </div>
          <div class="author-detail__content">
            <p class="author-detail__count">{{ author.followers }}</p>
            <span class="author-detail__what">Followers</span>
          </div>
          <div class="author-detail__content">
            <p class="author-detail__count">{{ author.followings }}</p>
            <span class="author-detail__what">Followings</span>
          </div>
        </div>

        <div class="author-detail__author-info">
          <h4 class="author-detail__bio-title">Bio</h4>
          <p class="author-detail__bio-text">{{ author.bio }}</p>
        </div>

        <ul class="author-detail__list list-reset">
          <li class="author-detail__item">
            <a href="#" class="author-detail__link">
              <svg width="16" height="16" class="author-detail__svg" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.93271 0C8.99321 0.0378781 10.0916 0.0378781 11.1521 0.0757512C12.099 0.113624 12.9701 0.265125 13.8033 0.757496C14.8638 1.40137 15.5077 2.34824 15.735 3.56023C15.8486 4.27985 15.8865 5.03735 15.9243 5.75698C15.9622 7.34771 15.9243 8.93846 15.9243 10.5292C15.9243 11.3624 15.8865 12.1957 15.6213 12.9911C15.0911 14.5439 13.9927 15.4908 12.402 15.7938C11.6823 15.9453 10.9248 15.9453 10.2052 15.9832C8.61446 16.021 7.06159 15.9832 5.47083 15.9832C4.63758 15.9832 3.80433 15.9453 3.00896 15.6802C1.45608 15.1499 0.509209 14.0515 0.206207 12.4608C0.0547099 11.7412 0.0547099 10.9837 0.0168343 10.2641C-0.0210429 8.67333 0.0168343 7.08259 0.0168343 5.49185C0.0168343 4.65861 0.0547099 3.82536 0.319834 3.02998C0.850086 1.47711 1.94846 0.530251 3.53921 0.227251C4.25884 0.0757562 5.01634 0.0757562 5.73596 0.0378781C6.45559 0 7.17521 0 7.93271 0V0ZM14.4863 7.84006C14.4863 7.84006 14.4484 7.84006 14.4863 7.84006C14.4484 7.19618 14.4484 6.59018 14.4484 5.94631C14.4484 5.34032 14.4105 4.73432 14.3348 4.12833C14.1833 2.76483 13.3879 1.85583 12.0623 1.59071C11.3805 1.43921 10.623 1.43921 9.94127 1.43921C8.57776 1.40134 7.25214 1.40134 5.88864 1.43921C5.20689 1.43921 4.52514 1.47708 3.88126 1.59071C2.74501 1.78008 1.94964 2.42396 1.60876 3.5602C1.49514 3.93895 1.45726 4.3177 1.41939 4.69644C1.38151 6.13569 1.38151 7.57493 1.38151 9.01417C1.38151 9.92317 1.41939 10.87 1.49514 11.779C1.60876 13.1425 2.44201 14.0894 3.80551 14.3166C4.48726 14.4303 5.20689 14.4681 5.92651 14.4681C7.25214 14.506 8.57776 14.4681 9.94127 14.4681C10.5473 14.4681 11.1533 14.4303 11.7593 14.3545C12.3274 14.3166 12.8576 14.1273 13.3121 13.7485C14.0696 13.1425 14.3348 12.3472 14.3726 11.4382C14.4484 10.3019 14.4484 9.08992 14.4863 7.84006Z" fill="currentColor"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0248 7.99134C12.0248 10.2638 10.2068 12.0818 7.93426 12.0818C5.66175 12.0818 3.84375 10.2638 3.84375 7.95347C3.84375 5.71886 5.69962 3.90088 7.97213 3.90088C10.2068 3.90088 12.0248 5.71886 12.0248 7.99134ZM7.93337 10.6426C9.37262 10.6426 10.5846 9.43063 10.5846 7.9914C10.5846 6.55216 9.37262 5.34017 7.93337 5.34017C6.45624 5.34017 5.28211 6.55216 5.28211 7.9914C5.24424 9.43063 6.45624 10.6426 7.93337 10.6426Z" fill="currentColor"/>
                <path d="M13.1222 3.71152C13.1222 4.24178 12.7055 4.69628 12.1753 4.69628C11.645 4.69628 11.1905 4.24178 11.2284 3.71152C11.2284 3.18128 11.645 2.76465 12.1753 2.76465C12.7055 2.76465 13.1222 3.18127 13.1222 3.71152Z" fill="currentColor"/>
              </svg>
            </a>
          </li>
          <li class="author-detail__item">
            <a href="#" class="author-detail__link">
              <svg width="17" height="16" class="author-detail__svg" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5486 9.32461V15.2112H13.1112V9.71132C13.1112 8.33635 12.6385 7.39106 11.3925 7.39106C10.4472 7.39106 9.88858 8.03558 9.63077 8.63713C9.54483 8.85196 9.50187 9.15274 9.50187 9.45351V15.2112H6.06442C6.06442 15.2112 6.10739 5.88718 6.06442 4.94189H9.50187V6.4028C9.50187 6.4028 9.50187 6.44576 9.4589 6.44576H9.50187V6.4028C9.97452 5.71531 10.7479 4.68408 12.5956 4.68408C14.8299 4.68408 16.5486 6.18796 16.5486 9.32461ZM2.54093 0.000610352C1.38079 0.000610352 0.607361 0.774033 0.607361 1.7623C0.607361 2.75055 1.33782 3.52398 2.49796 3.52398H2.54093C3.74404 3.52398 4.47449 2.75056 4.47449 1.7623C4.43153 0.774033 3.70107 0.000610352 2.54093 0.000610352ZM0.779264 15.2114H4.17375V4.94206H0.779264V15.2114Z" fill="currentColor" />
              </svg>
            </a>
          </li>
          <li class="author-detail__item">
            <a href="#" class="author-detail__link">
              <svg width="8" height="16" class="author-detail__svg" viewBox="0 0 8 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.32615 7.97131H5.09909V15.9419H1.77801V9.27536V7.97131H0.215149V5.15817H1.77801V3.32181C1.77801 2.03245 2.40316 0.000732422 5.09909 0.000732422H7.56058V2.73574H5.80237C5.52887 2.73574 5.09909 2.89203 5.09909 3.51717V5.15817H7.59966L7.32615 7.97131Z" fill="currentColor" />
              </svg>
            </a>
          </li>
          <li class="author-detail__item">
            <a href="#" class="author-detail__link">
              <svg width="17" height="14" class="author-detail__svg" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2071 1.8584C15.607 2.12096 15.0068 2.30851 14.3317 2.38352C15.0068 1.97093 15.532 1.33328 15.757 0.583116C15.1194 0.958199 14.4067 1.22076 13.694 1.37079C13.0939 0.733146 12.2312 0.320557 11.2935 0.320557C9.49306 0.320557 8.03022 1.78338 8.03022 3.58379C8.03022 3.84635 8.06773 4.1089 8.10524 4.33396C5.36711 4.18392 2.96655 2.90863 1.35368 0.920693C1.05361 1.4083 0.903576 1.97093 0.903576 2.57106C0.903576 3.69632 1.46621 4.70904 2.36642 5.30917C1.84129 5.30917 1.31617 5.15914 0.866067 4.89658V4.93409C0.866067 6.50944 1.99133 7.85974 3.49168 8.1598C3.22911 8.23482 2.92905 8.27233 2.62897 8.27233C2.40392 8.27233 2.21638 8.23482 2.02884 8.19732C2.44143 9.5101 3.64171 10.4478 5.10454 10.4853C3.97929 11.348 2.59146 11.8731 1.05361 11.8731C0.791052 11.8731 0.528492 11.8731 0.26593 11.8356C1.72877 12.7733 3.41666 13.2985 5.29209 13.2985C11.331 13.2985 14.5942 8.30984 14.5942 3.99638C14.5942 3.84635 14.5942 3.69632 14.5942 3.58379C15.2319 3.09618 15.7945 2.49604 16.2071 1.8584Z" fill="currentColor" />
              </svg>
            </a>
          </li>
        </ul>

      </div>
      <div class="author-detail__right">
        <div class="author-detail__tabs tab">

          <button class="btn-reset tab__btn tab__btn-collection" @click="activeTab = 1" :class="{ activeBtn: activeTab === 1 }">
            <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M19.3127 9.45684C19.3127 10.2645 20.0061 10.9217 20.8583 10.9217C21.2881 10.9217 21.6368 11.2523 21.6368 11.6596V14.3168C21.6368 16.5638 19.7082 18.3917 17.3374 18.3917H5.17724C2.80645 18.3917 0.876801 16.5638 0.876801 14.3168V11.6596C0.876801 11.2523 1.22557 10.9217 1.6553 10.9217C2.50854 10.9217 3.20192 10.2645 3.20192 9.45684C3.20192 8.66981 2.53657 8.07756 1.6553 8.07756C1.44874 8.07756 1.25152 7.99984 1.10516 7.86112C0.958803 7.72241 0.876801 7.5345 0.876801 7.33971L0.878877 4.5959C0.878877 2.3489 2.80748 0.52002 5.17828 0.52002H17.3354C19.7062 0.52002 21.6358 2.3489 21.6358 4.5959L21.6368 7.25412C21.6368 7.44891 21.5548 7.6378 21.4095 7.77553C21.2632 7.91425 21.0659 7.99197 20.8583 7.99197C20.0061 7.99197 19.3127 8.64915 19.3127 9.45684ZM13.5944 10.0995L14.8182 8.97007C15.031 8.77528 15.1047 8.48801 15.0123 8.22239C14.921 7.95676 14.6822 7.76787 14.3937 7.7295L12.7028 7.49536L11.9461 6.04327C11.8163 5.79339 11.5527 5.63795 11.2589 5.63696H11.2568C10.9641 5.63696 10.7005 5.79241 10.5686 6.04229L9.81193 7.49536L8.12414 7.72852C7.83246 7.76787 7.59372 7.95676 7.50134 8.22239C7.40999 8.48801 7.48369 8.77528 7.69544 8.97007L8.91925 10.0995L8.63068 11.6962C8.58086 11.9716 8.69815 12.2451 8.93689 12.4094C9.07183 12.5009 9.22857 12.5481 9.38739 12.5481C9.50883 12.5481 9.63132 12.5196 9.74342 12.4635L11.2568 11.71L12.7671 12.4616C13.0287 12.5944 13.3391 12.5737 13.5768 12.4084C13.8165 12.2451 13.9338 11.9716 13.884 11.6962L13.5944 10.0995Z" fill="currentColor" />
            </svg>
            Collection
          </button>

          <button class="btn-reset tab__btn tab__btn-collection" @click="activeTab = 2" :class="{ activeBtn: activeTab === 2 }">
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M0.71666 9.45628C0.71666 4.47387 4.75133 0.430176 9.74276 0.430176C14.7252 0.430176 18.7689 4.47387 18.7689 9.45628C18.7689 14.4477 14.7252 18.4824 9.74276 18.4824C4.75133 18.4824 0.71666 14.4477 0.71666 9.45628ZM11.7556 11.1078L13.2178 6.48648C13.3171 6.17056 13.0283 5.8727 12.7123 5.97199L8.09099 7.41617C7.90144 7.47935 7.74799 7.62377 7.69384 7.81331L6.24966 12.4437C6.15037 12.7506 6.44824 13.0485 6.75512 12.9492L11.3584 11.505C11.548 11.4508 11.7014 11.2974 11.7556 11.1078Z" fill="currentColor" />
            </svg>
            Activity
          </button>
        </div>

        <div class="tab__collection tab__container" v-if="activeTab === 1"  >
          <div v-if="authorWorks.length > 0" class="tab__content">
            <router-link :to="{ name: 'discover.show', params: {id: card.id} }" class="tab__card" v-for="(card, index) in authorWorks" :key="index"><NftCard :img="card.img" alt="card1" :title="card.title" :rate="card.currentBid" /> </router-link>
          </div>
          <div class="loader author-detail__loader" v-else-if="isLoading"></div>
          <MainHollow v-else />
        </div>


        <div class="tab__activity tab__container" v-if="activeTab === 2" >
          <div class="tab__content">
            <p Второй таб></p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss">
  .author-detail{
    //margin: 388px 0 180px 0;
    margin: 180px 0;
    &__container{
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 10px;
    }
    &__left{
      display: flex;
      flex-direction: column;
      grid-column: 4 span;
      .author-detail__author-info:nth-child(2) {
        margin-top: 30px;
        padding-bottom: 40px;
        border-bottom: 1.06px solid #d0d0d0;
      }
      .author-detail__author-info:nth-child(3) {
        margin-top: 43px;
      }
      .author-detail__author-info:nth-child(4) {
        margin-top: 116px;
        padding-bottom: 85px;
        border-bottom: 1.06px solid #d0d0d0;
      }
    }
    &__img-container{
      max-width: 165px;
      position: relative;
    }
    &__img{
      display: block;
      border-radius: 100%;
      border: 5px solid white;
      z-index: 1;
    }
    &__img-mark{
      position: absolute;
      bottom: 10px;
      right: 10px;
    }
    &__author-info{
      &:not(:nth-child(4)){
        display: flex;
        flex-direction: row;
        justify-content: space-between;
      }
    }
    &__content{
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    &__name{
      margin: 0;
      font-family: var(--font3);
      font-weight: 600;
      font-size: 35px;
      line-height: 130%;
      letter-spacing: 0.01em;
      color: #010101;
    }
    &__nickname{
      font-family: var(--font3);
      font-weight: 400;
      font-size: 18px;
      line-height: 130%;
      letter-spacing: 0.01em;
      color: #93989a;
    }
    &__btn{
      //height: auto;
      padding: 12px 23px;
      border-radius: 11px;
      font-size: 14px;
    }
    &__count{
      margin: 0;
      font-family: var(--font5);
      font-weight: 600;
      font-size: 32px;
      line-height: 125%;
      text-align: center;
      color: #141416;
    }
    &__what{
      font-family: var(--second-family);
      font-weight: 500;
      font-size: 10px;
      line-height: 150%;
      color: #848586;
    }
    &__bio-title{
      margin: 0;
      font-family: var(--font5);
      font-weight: 700;
      font-size: 25px;
      line-height: 161%;
      color: #c5c5c5;
    }
    &__bio-text{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 14px;
      line-height: 177%;
      text-transform: capitalize;
      color: #949494;
    }
    &__list{
      margin-top: 33px;
      display: flex;
      gap: 66px;
    }
    &__link{
      padding: 5px;
    }
    &__svg{
      color: black;
      transition: color .3s ease;
      position: relative;
      @media (hover:hover) {
        &:hover{
          color: #b3b2b2;
        }
      }
      &:active{
        color: #535353;
      }
      &::after{
        content: "";
        position: absolute;
        inset: 10px;
      }
    }
    &__right{
      margin-top: 73px;
      grid-column: 6/6 span;
      display: flex;
      flex-direction: column;
    }
    &__loader{
      margin: 0 auto;
      :not(:first-child){
        margin: 100px auto;
      }
    }
  }

  .tab{
    max-width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    &__btn{
      padding-bottom: 15px;
      width: 100%;
      font-family: var(--font-family);
      font-weight: 700;
      font-size: 16px;
      line-height: 153%;
      text-align: center;
      color: #d2d2d2;

    }
    .activeBtn{
      font-family: var(--font-family);
      font-weight: 700;
      font-size: 16px;
      line-height: 153%;
      color: #000;
      border-bottom: 4px solid #141416;
    }
    &__container{
      margin-top: 85px;
    }
    &__content{
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      column-gap: 10px;
      row-gap: 45px;
    }
    &__card{
      grid-column: 2 span;
    }
  }

  //.active-btn{
  //
  //}

  .tab__card .nft-card {
    max-width: 204px;
    padding: 10px 10px 14px 10px;
    border-radius: 17px;
    box-shadow: 28px 9px 43px 0 rgba(199, 199, 199, 0.6);
    position: relative;
    &__time{
      position: absolute;
      top: 20px;
      right: 17px;
      font-size: 10px;
      border: 0.86px solid rgba(28, 29, 32, 0.08);
      border-radius: 9px;
      padding: 6px 10px;
      backdrop-filter: blur(3.420224905014038px);
      box-shadow: 0 3px 10px 0 rgba(28, 29, 32, 0.08);
    }
    &__img{
      //max-width: 183px;
      border-radius: 14px;
    }
    &__content{
      margin-top: 13px;
      gap: 10px;
    }
    &__title{
      font-size: 15px;
    }
    &__current-bid{
      span{
        font-size: 10px;
      }
    }
    &__rate{
      margin: 0;
      padding-left: 10px;
      font-size: 11px;
      position: relative;
      &::before{
        width: 15px;
        height: 15px;
      }
    }
    &__btn{
      padding: 11px 18px;
      border-radius: 9px;
      font-size: 10px;
    }
  }

</style>