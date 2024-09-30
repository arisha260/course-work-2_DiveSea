<script setup>
  import Hero from '../components/MainHome/Hero.vue'
  import MainTopNft from '../components/MainHome/MainTopNft.vue'
  import TopCollection from '../components/MainHome/TopCollection.vue'
  import ExploreMarketplace from '../components/MainHome/ExploreMarketplace.vue'
  import CreateAndSellNFts from '@/components/MainHome/CreateAndSellNFts.vue'
  import InnerCollector from '@/components/MainHome/InnerCollector.vue'
</script>

<template>
  <div class="main">
    <Hero />
    <MainTopNft />
    <TopCollection />
    <ExploreMarketplace />
    <InnerCollector />
    <CreateAndSellNFts />
  </div>
</template>

<style lang="scss">

</style>