<script setup>
 defineProps({
   img: String,
   alt: String,
   name: String,
   nickname: String,
   followers: String,
 })
</script>

<template>
  <div class="author-card">
    <img :src="img" :alt="alt" class="author-card__img" width="67" height="67">
    <div class="author-card__author-info">
      <p class="author-card__name" >{{ name }} ({{ followers }})</p>
      <span class="author-card__nickname">@{{ nickname }}</span>
    </div>
      <button class="btn-reset main-button author-card__btn">Follow +</button>
  </div>
</template>

<style scoped lang="scss">
  .author-card{
    height: 100%;
    padding: 20px 19px;
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    align-items: center;
    background-color: #fff;
    border-radius: 23px;
    box-shadow: 39px 12px 59px 0 rgba(199, 199, 199, 0.6);
    position: relative;
    transition: all .3s ease;
    @media (max-width: 580px) {
      display: flex;
      flex-direction: row;
      align-items: center;
    }
    @media (max-width: 450px) {
      flex-direction: column;
      gap: 20px;
    }
    @media (hover: hover) {
      &:hover{
        transform: scale(1.05);
        //translate: 0 10px;
      }
    }
    &__img{
      border-radius: 100%;
      border: 2px solid #fff;
      grid-column: 2 span;
      @media (max-width: 580px) {
        margin-right: 10px;
      }
    }
    &__author-info{
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      grid-column: 4 span;
      justify-self: end;
      @media (max-width: 580px) {
        align-items: flex-start;
      }
    }
    &__name{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 21px;
      line-height: 140%;
      color: #141416;

    }
    &__nickname{
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 14px;
      line-height: 150%;
      letter-spacing: 0.01em;
      color: #94a3b8;

    }
    &__btn{
      margin-top: 10px;
      padding: 10px;
      white-space: nowrap;
      grid-column: 4/3 span;
      @media (max-width: 580px) {
        margin-left: auto;
      }
      @media (max-width: 450px) {
        margin: 0;
        width: 100%;
      }
    }
  }
</style>