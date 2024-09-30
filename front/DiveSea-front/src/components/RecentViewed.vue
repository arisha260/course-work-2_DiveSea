<script setup>
  defineProps({
    img: String,
    alt: String,
    name: String,
    nickname: String,
    rate: String,
    percents: String,
  })
</script>

<template>
   <div class="cards-resent__viewed">
     <img :src="img" :alt="alt" class="cards-resent__img" width="51" height="48">
     <div class="cards-resent__author">
       <p class="cards-resent__name">{{ name }}</p>
       <span class="cards-resent__nickname">{{ nickname }}</span>
     </div>
     <div class="cards-resent__info">
       <p class="cards-resent__rate">{{ rate }}</p>
       <span class="cards-resent__percents">{{ percents }}</span>
     </div>
   </div>
</template>

<style scoped lang="scss">
 .cards-resent__viewed{
    display: flex;
    align-items: center;
    &:not(:last-child){
      margin-bottom: 20px;
    }
  }
  .cards-resent__img{
    border: 1.92px solid #fff;
    border-radius: 50%;
  }
  .cards-resent__author{
    margin-left: 21px;
    display: flex;
    flex-direction: column;
  }
  .cards-resent__name{
    margin: 0;
    margin-bottom: 7px;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 15px;
    line-height: 140%;
    color: #141416;
  }
  .cards-resent__nickname{
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 12px;
    line-height: 150%;
    color: #64748b;
  }
  .cards-resent__info{
    margin-left: auto;
    display: flex;
    flex-direction: column;
  }
  .cards-resent__rate{
    margin: 0;
    padding-left: 7px;
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
      left: -15px;
      background-repeat: no-repeat;
      background-size: cover;
      width: 22px;
      height: 22px;
    }
  }
  .cards-resent__percents{
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 13px;
    line-height: 150%;
    color: #10c352;
  }
</style>