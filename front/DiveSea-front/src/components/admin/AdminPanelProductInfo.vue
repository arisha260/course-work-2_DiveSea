<script setup>
defineProps({
  title: String,
  description: String,
  royalty: String,
  inStock: String,
  price: String,
  saleType: Boolean,
})

const emit = defineEmits(['close'])

// Функция для уведомления родительского компонента о закрытии
const handleClose = () => {
  emit('close')
}
</script>

<template>
  <div class="admin-info">
    <!-- Кнопка закрытия вызывает handleClose -->
    <svg @click="handleClose" class="admin-info__close" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
      <g id="SVGRepo_iconCarrier">
        <path d="M19 5L5 19M5.00001 5L19 19" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
      </g>
    </svg>
    <h3 class="admin-info__title">Information about product</h3>
    <p class="admin-info__text admin-info__product-title">Product Title: {{ title }}</p>
    <p class="admin-info__text admin-info__product-descr">Product Description: {{ description }}</p>
    <p class="admin-info__text admin-info__product-royalty">Product Royalty: {{ royalty }}</p>
    <p class="admin-info__text admin-info__product-quantity">Product Quantity: {{ inStock }}</p>
    <p class="admin-info__text admin-info__product-price">Product Price:{{ price }}</p>
    <p class="admin-info__text admin-info__product-saleType">Product Sale Type:{{ saleType }}</p>
    <div class="admin-info__btns">
      <button class="btn-reset main-button admin-info__btn admin-info__accept">Accept</button>
      <button class="btn-reset main-button admin-info__btn admin-info__denial">Denial</button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.admin-info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  position: relative;

  &__title {
    margin: 0;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 20px;
    line-height: 125%;
    color: #000;
  }

  &__text {
    margin: 0;
    font-family: var(--second-family);
    font-weight: 400;
    font-size: 18px;
    line-height: 156%;
    text-align: justify;
    color: #676767;
  }

  &__btns {
    display: flex;
    flex-direction: row;
    gap: 20px;
  }

  &__btn {
    padding: 19px 25px;
  }

  &__close {
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
  }
}
</style>
