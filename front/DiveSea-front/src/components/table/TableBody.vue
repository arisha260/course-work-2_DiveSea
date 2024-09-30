<script setup>
defineProps({
  img: String,
  alt: String,
  name: String,
  nickname: String,
  volume: Number,
  percents: Number,
  price: Number,
  owners: Number,
  items: Number,
})
</script>

<template>
  <tr class="table__row">
    <td class="table__item">
      <div class="table__author">
        <img :src="img" :alt="alt" class="table__img" width="84" height="84">
        <div class="table__author-data">
          <p class="main-name table__name">{{ name }}</p>
          <span class="main-nickname table__nickname">{{ nickname }}</span>
        </div>
      </div>
    </td>
    <td class="table__item"><p class="text-with-bg main-volume table__volume">{{ volume }}</p></td>
    <td class="table__item"><p class="main-percents table__percents">{{ percents }}</p></td>
    <td class="table__item"><p class="text-with-bg main-price table__price">{{ price }}</p></td>
    <td class="table__item"><p class="main-owners table__owners">{{ owners }}</p></td>
    <td class="table__item"><p class="main-items table__items">{{ items }}</p></td>
  </tr>
  <!-- Добавьте больше строк по необходимости -->
</template>

<style scoped lang="scss">

</style>