<script setup>
  import NftCard from '@/components/NftCard.vue'
  import RecentViewed from '@/components/RecentViewed.vue'
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import { Navigation, Pagination } from 'swiper/modules';
  import 'swiper/css';
  import 'swiper/css/navigation';
</script>

<template>
  <section class="cards">
    <div class="container cards__container">
      <h1 class="main-title cards__title">Weekly - Top NFT</h1>
      <Swiper
        :modules="[Navigation, Pagination]"
        slides-per-view="4.5"
        space-between="40"
        :loop="false"
        :navigation="{
        nextEl: '.cards__pagination-btn_next',
        prevEl: '.cards__pagination-btn_prev',
        }"
        :pagination="{ clickable: true }"
        class="swiper"
      >
        <SwiperSlide class="swiper-slide"><NftCard img="/card1.png" alt="card1" title="Sun-Glass" rate="1.75"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card2.png" alt="card2" title="Sun-Glass" rate="1.75"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card3.png" alt="card3" title="Sun-Glass" rate="1.75"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card4.png" alt="card4" title="NuEvey" rate="1.25"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card5.png" alt="card5" title="NuEvey" rate="1.25"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card4.png" alt="card4" title="NuEvey" rate="1.25"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card5.png" alt="card5" title="NuEvey" rate="1.25"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card4.png" alt="card4" title="NuEvey" rate="1.25"/></SwiperSlide>
        <SwiperSlide class="swiper-slide"><NftCard img="/card5.png" alt="card5" title="NuEvey" rate="1.25"/></SwiperSlide>
      </Swiper>
      <div class="cards__pagination">
        <button class="btn-reset cards__pagination-btn cards__pagination-btn_prev">
          <svg width="17" height="10" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.23973 0.389755C5.80229 -0.0140416 5.12034 0.0132326 4.71654 0.450673L1.23402 4.22336C0.852869 4.63627 0.852865 5.27271 1.23401 5.68562L4.71653 9.45839C5.12032 9.89584 5.80228 9.92312 6.23973 9.51933C6.67717 9.11554 6.70445 8.43358 6.30066 7.99614L4.48802 6.03242L14.9611 6.03242C15.5565 6.03242 16.0391 5.54982 16.0391 4.9545C16.0391 4.35918 15.5565 3.87657 14.9611 3.87657L4.48805 3.87657L6.30065 1.91295C6.70445 1.47551 6.67717 0.793551 6.23973 0.389755Z" fill="currentColor" />
        </svg>
        </button>
        <button class="btn-reset cards__pagination-btn cards__pagination-btn_next">
          <svg width="17" height="10" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7603 0.389755C11.1977 -0.0140416 11.8797 0.0132326 12.2835 0.450673L15.766 4.22336C16.1471 4.63627 16.1471 5.27271 15.766 5.68562L12.2835 9.45839C11.8797 9.89584 11.1977 9.92312 10.7603 9.51933C10.3228 9.11554 10.2955 8.43358 10.6993 7.99614L12.512 6.03242L2.03886 6.03242C1.44354 6.03242 0.960937 5.54982 0.960937 4.9545C0.960937 4.35918 1.44354 3.87657 2.03886 3.87657L12.5119 3.87657L10.6993 1.91295C10.2956 1.47551 10.3228 0.793551 10.7603 0.389755Z" fill="currentColor" />
          </svg>
        </button>
      </div>
    </div>
    <div class="cards__recent cards-resent">
      <div class="cards-resent__top">
        <h3 class="cards-resent__title">Recent Viewed</h3>
        <svg width="18" height="4" viewBox="0 0 18 4" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8 1.61536C8 1.86157 8.44772 2.06116 9 2.06116C9.55228 2.06116 10 1.86157 10 1.61536C10 1.36915 9.55228 1.16956 9 1.16956C8.44772 1.16956 8 1.36915 8 1.61536Z" stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M1 1.61536C1 1.86157 1.44772 2.06116 2 2.06116C2.55228 2.06116 3 1.86157 3 1.61536C3 1.36915 2.55228 1.16956 2 1.16956C1.44772 1.16956 1 1.36915 1 1.61536Z" stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M15 1.61536C15 1.86157 15.4477 2.06116 16 2.06116C16.5523 2.06116 17 1.86157 17 1.61536C17 1.36915 16.5523 1.16956 16 1.16956C15.4477 1.16956 15 1.36915 15 1.61536Z" stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <div class="cards-resent__bottom">
        <RecentViewed img="/cards__recent-1.png" alt="recent img" name="Alex Ca." nickname="Alexy" rate="8,456" percents="+23,00%" />
        <RecentViewed img="/cards__recent-2.png" alt="recent img" name="Juliya S." nickname="JuliyaS" rate="5,327" percents="-32,01%" />
      </div>
    </div>

  </section>
</template>

<style scoped lang="scss">
.cards{
  padding-bottom: 90px;
  background: #f1f1f1;
  position: relative;
  &__container{
    max-width: 1500px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    overflow-x: hidden;
  }
  &__title{
    margin-top: 70px;
    line-height: 60%;
    color: #c5c5c5;
  }
  &__pagination{
    display: flex;
    align-items: center;
    border-radius: 17px;
    box-shadow: 0 43px 34px -26px rgba(15, 15, 15, 0.12);
    background: #fcfcfd;
    position: relative;
    &::before{
      content: "";
      position: absolute;
      inset: 50%;
      transform: translateY(-50%);
      border-radius: 2px;
      width: 2px;
      height: 25px;
      background: #e6e8ec;
    }
  }
  &__pagination-btn{
    color: #23262f;
    transition: all .2s ease;
    &:focus{
      outline: none;
    }
    &:hover{
      color: #929292;
    }
    &:active{
      color: #000000;
    }
    &:nth-child(1){
      padding: 29px 40px 29px 27px;

    }
    &:nth-child(2){
      padding: 29px 27px 29px 40px;
    }
  }

}

.swiper{
  padding: 100px 50px 114px 50px;
  &-slide{
    max-width: 281px;
  }
}

.cards-resent {
  padding: 26px 24px 21px 27px;
  width: 365px;
  border: 1px solid #edf2f7;
  border-radius: 16px;
  box-shadow: 10px 10px 50px 0 rgba(20, 20, 22, 0.1);
  background: #fff;
  position: absolute;
  bottom: -10%;
  right: 100px;
  &__top{
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  &__title {
    margin: 0;
    font-family: var(--font-family);
    font-weight: 600;
    font-size: 21px;
    line-height: 135%;
    letter-spacing: 0.01em;
    color: #1a202c;
    position: relative;
  }
  &__bottom{
    display: flex;
    flex-direction: column;
  }
}
</style>