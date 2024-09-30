<script setup>

defineProps({
  img: String,
  alt: String,
  title: String,
  author: String,
  rate: String,
  likes: String,
})
</script>

<template>
  <div class="nft-card-from">
    <img :src="img" class="nft-card-from__img" :alt="alt" width="187" height="164">
    <div class="nft-card-from__content">
      <h4 class="nft-card-from__author">{{ author }}
        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8.62482" cy="8.5412" r="8.06281" fill="white" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.62534 1.65686C4.82315 1.65686 1.74072 4.73929 1.74072 8.54148C1.74072 12.3437 4.82315 15.4261 8.62534 15.4261C12.4275 15.4261 15.51 12.3437 15.51 8.54148C15.51 4.73929 12.4275 1.65686 8.62534 1.65686ZM11.6095 7.37735C11.6645 7.31454 11.7063 7.24137 11.7325 7.16216C11.7588 7.08294 11.769 6.99927 11.7624 6.91607C11.7558 6.83288 11.7327 6.75183 11.6944 6.6777C11.656 6.60358 11.6032 6.53787 11.5391 6.48444C11.475 6.43102 11.4009 6.39095 11.321 6.3666C11.2412 6.34226 11.1573 6.33412 11.0743 6.34267C10.9913 6.35123 10.9108 6.3763 10.8376 6.41641C10.7645 6.45652 10.7 6.51086 10.6482 6.57623L7.95691 9.80512L6.56434 8.41192C6.4463 8.29791 6.2882 8.23483 6.1241 8.23626C5.95999 8.23768 5.80302 8.3035 5.68697 8.41955C5.57093 8.53559 5.50511 8.69257 5.50368 8.85667C5.50226 9.02077 5.56534 9.17887 5.67935 9.29691L7.55697 11.1745C7.61847 11.236 7.6921 11.284 7.77316 11.3154C7.85422 11.3468 7.94095 11.361 8.0278 11.3571C8.11465 11.3531 8.19973 11.3311 8.27761 11.2925C8.35549 11.2538 8.42447 11.1994 8.48014 11.1326L11.6095 7.37735Z" fill="#007AFF" />
        </svg>
      </h4>
      <p class="nft-card-from__title">{{ title }}</p>
      <div class="nft-card-from__content-bottom">
        <p class="nft-card-from__current-bid">
          {{ rate }}
        </p>
        <button class="btn-reset nft-card-from__btn">
          <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.8704 2.40342L11.8698 2.40286C11.5592 2.09844 11.1931 1.85652 10.7912 1.69025L10.7903 1.68987C10.3733 1.51665 9.92608 1.42799 9.47455 1.42903L9.4729 1.42903C8.83736 1.42903 8.21862 1.60299 7.68154 1.93063L7.68152 1.93064C7.553 2.00904 7.43144 2.09481 7.31658 2.18798L6.86623 2.55326L6.41588 2.18798C6.30101 2.09481 6.17945 2.00904 6.05094 1.93064L6.05092 1.93063C5.51384 1.60299 4.8951 1.42903 4.25956 1.42903C3.80063 1.42903 3.35923 1.51662 2.94213 1.68987L2.94136 1.69019C2.53786 1.85725 2.17493 2.09703 1.86245 2.40307L1.86148 2.40403L1.86148 2.40403C1.55227 2.70572 1.30527 3.06515 1.13447 3.46194L11.8704 2.40342ZM11.8704 2.40342C12.1795 2.70577 12.4267 3.06548 12.5982 3.46242C12.7758 3.87533 12.8659 4.31151 12.8646 4.76122V4.76325C12.8646 5.18297 12.7789 5.63586 12.5963 6.11354L12.5956 6.11516C12.4445 6.51337 12.2188 6.94072 11.9211 7.38514C11.4502 8.08713 10.7897 8.83793 9.94876 9.61433C8.54951 10.9051 7.16262 11.7977 7.11615 11.8275L7.11602 11.8276L6.86545 11.9883L6.61489 11.8276L6.61496 11.8275L6.60366 11.8206C6.60404 11.8208 6.60355 11.8205 6.60217 11.8196C6.59642 11.8159 6.57527 11.8024 6.53736 11.7775C6.49292 11.7483 6.42975 11.7062 6.3505 11.6523C6.19196 11.5443 5.96987 11.3893 5.70519 11.1944C5.17475 10.8039 4.47889 10.2578 3.78243 9.61459L3.78235 9.61452M11.8704 2.40342L3.78235 9.61452M3.78235 9.61452C2.94144 8.83818 2.28094 8.08743 1.81006 7.38549L3.78235 9.61452ZM0.866274 4.76325C0.866274 4.31201 0.956711 3.87502 1.13444 3.462L1.13463 6.11349C0.951957 5.63583 0.866274 5.18296 0.866274 4.76325ZM1.80982 7.38514C1.51306 6.9421 1.28812 6.51411 1.13464 6.11354L1.80982 7.38514Z" stroke="currentColor" stroke-width="1.42981" />
          </svg>
          {{ likes }}
        </button>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.nft-card-from {
  max-width: 215px;
  height: 100%;
  padding: 14px;
  display: flex;
  flex-direction: column;
  border-radius: 17px;
  box-shadow: 17px 12px 60px 0 rgba(97, 97, 97, 0.25);
  background: #fff;
  position: relative;
  transition: all .3s ease;
  //@media (hover: hover) {
  //  &:hover{
  //    transform: scale(1.05);
  //  }
  //}
  &__img{
    border-radius: 12px;
    user-select: none;
    pointer-events: none;
    -webkit-user-drag: none;
    user-drag: none;
  }
  &__content{
    margin-top: 7px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    gap: 14px;
  }
  &__author{
    margin: 0;
    margin-bottom: 7px;
    font-family: var(--font-family);
    font-weight: 700;
    font-size: 14px;
    line-height: 157%;
    color: #141416;
    svg{
      transform: translateY(20%);
    }
  }
  &__title{
    margin: 0;
    margin-bottom: 7px;
    font-family: var(--font-family);
    font-weight: 600;
    font-size: 17px;
    line-height: 157%;
    color: #141416;
  }
  &__content-bottom{
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  &__current-bid{
    margin: 0;
    padding-left: 21px;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 18px;
    line-height: 144%;
    text-align: center;
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
    font-family: var(--font-family);
    font-weight: 600;
    font-size: 12px;
    line-height: 144%;
    text-align: center;
    color: #888;
    transition: all .4s ease;
    svg{
      margin-right: 5px;
      transform: translateY(15%);
    }
    @media (hover: hover) {
      &:hover{
        color: red;
      }
    }
  }
}
</style>