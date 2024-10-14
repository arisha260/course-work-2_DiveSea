<script setup>

</script>

<template>
  <section class="hero">
    <div class="container hero__container">
    <div class="hero__left">
      <h1 class="hero__title">Discover And Create NFTs</h1>
      <p class="hero__descr">Discover, Create and Sell NFTs On Our NFT Marketplace With Over Thousands Of NFTs And Get a <b>$20 bonus.</b></p>
      <div class="hero__btns">
        <a href="#" class="main-button hero__btn hero__btn-black">Explore More</a>
        <router-link :to="{ name: 'sell' }" href="#" class="main-button hero__btn hero__btn-white">create NFT</router-link>
      </div>
      <div class="hero__counts">
        <div class="hero__counts-column">
          <h3 class="hero__counts-count">430K+</h3>
          <span class="hero__counts-what">Art Works</span>
        </div>
        <div class="hero__counts-column">
          <h3 class="hero__counts-count">159K+</h3>
          <span class="hero__counts-what">Creators</span>
        </div>
        <div class="hero__counts-column">
          <h3 class="hero__counts-count">87K+</h3>
          <span class="hero__counts-what">Collections</span>
        </div>
      </div>
    </div>
    <div class="hero__right">
      <picture>
        <source srcset="/Hero-img.png" type="image/webp">
        <img loading="lazy" src="/Hero-img.png" class="hero__img" width="780" height="553" alt="section hero img">
      </picture>
    </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
.hero{
  margin-top: 100px;
  margin-bottom: 147px;
  @media (max-width: 800px) {
    margin-top: 74px;
    margin-bottom: 113px;
  }
  &__container{
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    align-items: center;
    @media (max-width: 800px) {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 60px;
    }
  }
  &__left{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    grid-column: 5 span;
    @media (max-width: 1200px) {
      grid-column: 4 span;
    }
    @media (max-width: 800px) {
      align-items: center;
      justify-content: center;
    }
  }
  &__title{
    margin: 0;
    margin-bottom: 16px;
    font-family: var(--font-family);
    font-weight: 600;
    font-size: 75px;
    line-height: 120%;
    letter-spacing: -0.04em;
    text-transform: capitalize;
    @media (max-width: 1200px) {
      font-size: 53px;
      margin-bottom: 11px;
    }
    @media (max-width: 800px) {
      text-align: center;
    }
  }
  &__descr{
    margin: 0;
    margin-bottom: 45px;
    font-family: var(--second-family);
    font-weight: 400;
    font-size: 18px;
    line-height: 156%;
    text-align: justify;
    color: #676767;
    @media (max-width: 1200px) {
      font-size: 12px;
      margin-bottom: 31px;
    }
    @media (max-width: 800px) {
      text-align: center;
    }
  }
  &__btns{
    margin-bottom: 82px;
    display: flex;
    align-items: center;
    gap: 23px;
    @media (max-width: 1200px) {
      margin-bottom: 58px;
    }
  }
  &__btn{
    padding: 18px 30px;
    border-radius: 12px;
    @media (max-width: 1200px) {
      font-size: 11px;
      padding: 12px 20px;
      border-radius: 9px;
    }
  }
  &__btn-white{
    color: #000;
    background: #fff;
    border: 1.50px solid #000;
  }
  &__counts{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    @media (max-width: 800px) {
      gap: 50px;
      justify-content: center;
    }
  }
  &__counts-column{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  &__counts-count{
    margin: 0;
    font-family: var(--font5);
    font-weight: 600;
    font-size: 36px;
    line-height: 125%;
    text-align: center;
    color: #141416;
    @media (max-width: 1200px) {
      font-size: 26px;
    }
  }
  &__counts-what{
    font-family: var(--second-family);
    font-weight: 500;
    font-size: 12px;
    line-height: 150%;
    text-align: center;
    color: #848586;
    @media (max-width: 1200px) {
      font-size: 8px;
    }
  }
  &__right{
    grid-column: 7/6 span;
    @media (max-width: 1200px) {
      grid-column: 6/7 span;
    }
    @media (max-width: 800px) {
      display: none;
    }
    img{
      user-select: none;
      pointer-events: none;
      -webkit-user-drag: none;
      user-drag: none;
      @media (max-width: 1200px) {
        width: 554px;
      }
    }
  }
}
</style>