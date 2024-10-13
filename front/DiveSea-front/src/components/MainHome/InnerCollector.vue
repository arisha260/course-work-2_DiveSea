<script setup>

</script>

<template>
  <section class="inner-collector">
    <div class="container inner-collector__container">
      <div class="inner-collector__left">
        <h1 class="main-title inner-collector__title"><span>Just Unleash -</span><br>Your Inner Collector</h1>
        <ul class="list-reset inner-collector__list">
          <li class="inner-collector__item">Best Seller All Around World</li>
          <li class="inner-collector__item">$2M+ Transections Every Day</li>
          <li class="inner-collector__item">Secure Transactions</li>
          <li class="inner-collector__item">Exclusive Collections From Sellers</li>
          <li class="inner-collector__item">Easy Buying and Selling</li>
          <li class="inner-collector__item">Join Our Community</li>
        </ul>
        <a href="" class="btn-reset inner-collector__btn">Explore More
          <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.98047 11.0702H17.8973" stroke="white" stroke-width="1.84503" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M11.4365 4.61316L17.8949 11.0716L11.4365 17.53" stroke="white" stroke-width="1.84503" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </a>
      </div>
      <div class="inner-collector__right">
        <img src="/inner-collection.png" alt="inner section img" width="836" height="613">
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
  .inner-collector{
    margin-top: 103px;
    @media (max-width: 1200px) {
      margin-top: 53px;
    }
    &__container{
      padding-top: 116px;
      border-top: 0.71px solid #cbcbcb;
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      align-items: center;
      @media (max-width: 1200px) {
        padding-top: 53px;
      }
    }
    &__title{
      margin-bottom: 45px;
      text-transform: capitalize;
      @media (max-width: 1200px) {
        margin-bottom: 31px;
      }
      span{
        color: #c5c5c5
      }
    }
    &__left{
      grid-column: 5 span;
    }
    &__list{
      margin-bottom: 90px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
      @media (max-width: 1200px) {
        gap: 8px;
        margin-bottom: 50px;
      }
    }
    &__item{
      padding-left: 32px;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 16px;
      line-height: 200%;
      color: #12141d;
      position: relative;
      @media (max-width: 1200px) {
        padding-left: 16px;
        font-size: 11px;
        border-radius: 9px;
      }
      &::before{
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        transform: translateY(28%);
        background-image: url("/mark.png");
        background-repeat: no-repeat;
        background-size: cover;
        width: 20px;
        height: 20px;
        @media (max-width: 1200px) {
          transform: translateY(40%);
          width: 10px;
          height: 10px;
        }
      }
    }
    &__btn{
      max-width: 165px;
      padding: 18px 14px 19px 21px;
      display: flex;
      align-items: center;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 14px;
      line-height: 125%;
      text-transform: capitalize;
      text-align: center;
      color: #fff;
      background: #000;
      border-radius: 12px;
      @media (max-width: 1200px) {
        max-width: 115px;
        padding: 12px 10px 13px 14px;
        font-size: 10px;
        border-radius: 9px;
      }
      svg{
        margin-left: 11px;
        transition: all .2s ease;
        @media (max-width: 1200px) {
          margin-left: 7px;
          width: 15px;
          height: 15px;
        }
      }
      @media(hover:hover){
        &:hover svg{
          margin-left: 17px;
        }
      }
    }
    &__right{
      grid-column: 7 span;
      user-select: none;
      pointer-events: none;
      -webkit-user-drag: none;
      user-drag: none;
    }
  }
</style>