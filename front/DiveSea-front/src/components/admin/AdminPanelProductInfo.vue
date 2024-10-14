<script setup>
import { useAdminStore } from '@/stores/Admin/adminStore.js'
import { storeToRefs } from 'pinia'

const store = useAdminStore()
const { currentNft } = storeToRefs(store)

const approveNft = async () => {
  const formData = new FormData();

  if (currentNft.value) {
    formData.append('title', currentNft.value.title);
    formData.append('description', currentNft.value.description);
    formData.append('royalty', currentNft.value.royalty);
    formData.append('sale_type', currentNft.value.sale_type);
    formData.append('currentBid', currentNft.value.currentBid);
    formData.append('price', currentNft.value.price);
    formData.append('in_stock', currentNft.value.in_stock);
    formData.append('author_id', currentNft.value.author.id);
    formData.append('img', currentNft.value.img);
  }
  await store.sendApprovedNft(currentNft.value.id, formData);
  handleClose();
}

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
    <p class="admin-info__text admin-info__product-author">Product Author: {{ currentNft.author.name }}</p>
    <p class="admin-info__text admin-info__product-title">Product Title: {{ currentNft.title }}</p>
    <p class="admin-info__text admin-info__product-descr">Product Description: {{ currentNft.description }}</p>
    <p class="admin-info__text admin-info__product-royalty">Product Royalty: {{ currentNft.royalty }}</p>
    <p class="admin-info__text admin-info__product-quantity">Product Quantity: {{ currentNft.in_stock }}</p>
    <p class="admin-info__text admin-info__product-price">Product Price: {{ currentNft.price }}</p>
    <p class="admin-info__text admin-info__product-saleType">Product Sale Type: {{ currentNft.sale_type }}</p>
    <div class="admin-info__btns">
      <button @click.prevent="approveNft(); handleClose()" class="btn-reset main-button admin-info__btn admin-info__accept">Accept</button>
      <button @click.prevent="store.rejectNft(currentNft.id)" @click="handleClose" class="btn-reset main-button admin-info__btn admin-info__denial">Denial</button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.admin-info {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  position: relative;
  @media (max-width: 690px) {
    max-width: 300px;
  }

  &__title {
    margin: 0;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 20px;
    line-height: 125%;
    color: #000;
    @media (max-width: 690px) {
      font-size: 16px;
    }
  }

  &__text {
    margin: 0;
    font-family: var(--second-family);
    font-weight: 400;
    font-size: 18px;
    line-height: 156%;
    color: #676767;
    //white-space: normal;
    //overflow-wrap: break-word;
    //word-wrap: break-word;
    word-break: break-word;
    @media (max-width: 690px) {
      font-size: 14px;
    }
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
