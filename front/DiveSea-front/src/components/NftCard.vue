<script setup>

defineProps({
  img: String,
  alt: String,
  title: String,
  rate: String,
})
</script>

<template>
  <div class="nft-card">
    <span class="nft-card__time">07h 09m 12s</span>
    <img :src="img" class="nft-card__img" :alt="alt" width="252" height="252">
    <div class="nft-card__content">
      <p class="nft-card__title">{{ title }}</p>
      <div class="nft-card__content-bottom" v-if="rate">
        <div class="nft-card__current-bid">
          <span>Current bid</span>
          <p class="nft-card__rate">{{ rate }}</p>
        </div>
        <a href="#" class="main-button nft-card__btn">PLACE BID</a>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
  .nft-card {
    max-width: 281px;
    height: 100%;
    padding: 20px 19px;
    flex-direction: column;
    display: flex;
    background-color: #fff;
    border-radius: 23px;
    box-shadow: 39px 12px 59px 0 rgba(199, 199, 199, 0.6);
    position: relative;
    transition: all .3s ease;
    @media (hover: hover) {


      &:hover{
        transform: scale(1.05);
        //translate: 0 10px;
      }
    }
    &__time{
      position: absolute;
      top: 35px;
      right: 30px;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 14px;
      line-height: 150%;
      letter-spacing: 0.01em;
      color: #fff;
      border: 1.18px solid rgba(28, 29, 32, 0.08);
      border-radius: 9px;
      padding: 9px 14px;
      backdrop-filter: blur(4.705041408538818px);
      box-shadow: 0 5px 14px 0 rgba(28, 29, 32, 0.08);
      background: rgba(28, 29, 32, 0.35);
      user-select: none;
    }
    &__img{
      max-height: 240px;
      border-radius: 23px;
      user-select: none;
      pointer-events: none;
      -webkit-user-drag: none;
      user-drag: none;
    }
    &__content{
      margin-top: 19px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
      gap: 14px;
    }
    &__title{
      margin: 0;
      margin-top: auto;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 21px;
      line-height: 140%;
      color: #141416;
    }
    &__content-bottom{
      margin-top: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    &__current-bid{
      span{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 14px;
        line-height: 150%;
        letter-spacing: 0.01em;
        color: #94a3b8;
      }
    }
    &__rate{
      margin: 0;
      padding-left: 18px;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 16px;
      line-height: 150%;
      color: #141416;
      position: relative;
      &::before{
        content: '';
        position: absolute;
        background-image: url("/rate-png.png");
        top: 0;
        left: -5px;
        background-repeat: no-repeat;
        background-size: cover;
        width: 22px;
        height: 22px;
      }
    }
    &__btn{
      padding: 9px 18px;
      border-radius: 12px;
      &::after{
        content: "";
        position: absolute;
        inset: 0;
      }
    }
  }
</style>