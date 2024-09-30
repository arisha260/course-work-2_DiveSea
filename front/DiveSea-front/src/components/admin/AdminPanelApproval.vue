<script setup>
import NftCard from '@/components/NftCard.vue'
import AdminPanelProductInfo from '@/components/admin/AdminPanelProductInfo.vue'
import { useAdminStore } from '@/stores/Admin/adminStore.js'
import { storeToRefs } from 'pinia'
import { ref, onMounted, onBeforeUnmount } from 'vue'

const store = useAdminStore();
const { nfts, currentNft } = storeToRefs(store);

const isModalOpen = ref(false); // Для состояния модального окна

// Открываем модальное окно с выбранным NFT
const openProductInfo = (nft) => {
  currentNft.value = nft;
  isModalOpen.value = true;
}

// Закрываем модальное окно
const closeProductInfo = () => {
  isModalOpen.value = false;
  currentNft.value = null;
}

// Обработчик для закрытия по нажатию клавиши "Esc"
const handleKeyPress = (e) => {
  if (e.key === 'Escape') {
    closeProductInfo();
  }
};

// Вешаем слушатель на нажатие клавиш при монтировании
onMounted(() => {
  window.addEventListener('keydown', handleKeyPress);
  store.getNftApprove();
});

// Убираем слушатель при размонтировании
onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeyPress);
});
</script>

<template>
  <div class="admin-approval">
    <div class="container admin-approval__container">
      <!-- Карточки NFT -->
      <NftCard @click="openProductInfo(card)"
               v-for="(card, index) in nfts"
               :key="index"
               class="admin-approval__card"
               :img="card.img"
               alt="card1"
               :title="card.title"
               :rate="card.currentBid" />

      <!-- Модальное окно с информацией -->
      <AdminPanelProductInfo
        class="admin-approval__info"
        v-if="isModalOpen"
        ref="InfoRef"
        :nft="currentNft"
        :title="currentNft.title"
        :description="currentNft.description"
        :royalty="currentNft.royalty"
        :inStock="currentNft.in_stock"
        :price="currentNft.price"
        @close="closeProductInfo"
      />
    </div>
  </div>
</template>

<style scoped lang="scss">
.admin-approval {
  position: relative;

  &__container {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    align-items: center;
  }

  &__card {
    grid-column: 3 span;
  }

  &__info {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 23px;
    box-shadow: 39px 12px 59px 0 rgba(199, 199, 199, 0.6);
  }
}
</style>
