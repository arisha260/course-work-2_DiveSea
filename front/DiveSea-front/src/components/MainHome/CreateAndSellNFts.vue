<script setup>

</script>

<template>
  <section class="create-and-sell-nfts">
    <div class="container create-and-sell-nfts__container">
      <div class="create-and-sell-nfts__left">
        <h1 class="main-title create-and-sell-nfts__title">Create and Sell NFTs</h1>
        <span class="create-and-sell-nfts__descr">World’s Largest NFT Place</span>
        <div class="create-and-sell-nfts__btns">
          <a href="#" class="create-and-sell-nfts__btn create-and-sell-nfts__btn-white">Explore More</a>
          <a href="#" class="create-and-sell-nfts__btn create-and-sell-nfts__btn-black">Sell Artwork</a>
        </div>
      </div>
      <div class="create-and-sell-nfts__right">
        <img class="create-and-sell-nfts__img" src="/create-and-sell.png" alt="create and sell nft img" width="369" height="249">
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
  .create-and-sell-nfts{
    margin-top: 180px;
    margin-bottom: 160px;
    &__container{
      padding: 31px 22px 16px 61px;
      border-radius: 30px;
      background: #141416;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      z-index: 1;
      &::before {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 390px;
        height: 249px;
        background-image: url("/create-and-sell.png"); /* Та же картинка */
        background-size: cover;
        background-repeat: no-repeat;
        filter: blur(52.874610900878906px); /* Применяем размытие */
        z-index: -1; /* Псевдоэлемент должен быть позади изображения */
        border-radius: 8px; /* Тот же радиус, что и у изображения */
      }
    }
    &__title{
      margin-bottom: 13px;
      line-height: 130%;
      letter-spacing: 0.01em;
      color: #fff;
    }
    &__left{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    &__descr{
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 20px;
      line-height: 130%;
      letter-spacing: 0.01em;
      color: #d4d4d4;
    }
    &__btns{
      margin-top: 50px;
      display: flex;
      align-items: center;
      gap: 30px;
    }
    &__btn{
      padding: 19px 25px;
      font-family: var(--font3);
      font-weight: 600;
      font-size: 21px;
      line-height: 130%;
      letter-spacing: 0.01em;
      color: #141416;
      border-radius: 12px;
      background: #fff;
    }
    &__btn-black{
      border: 2.29px solid #fff;
      background-color: transparent;
      color: #fff;
    }
    &__img {
      border-radius: 8px;
      user-select: none;
      pointer-events: none;
      -webkit-user-drag: none;
      user-drag: none;
    }
  }
</style>