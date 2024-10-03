<script setup>
import Hero from '../components/MainHome/Hero.vue'
import MainTopNft from '../components/MainHome/MainTopNft.vue'
import TopCollection from '../components/MainHome/TopCollection.vue'
import ExploreMarketplace from '../components/MainHome/ExploreMarketplace.vue'
import CreateAndSellNFts from '@/components/MainHome/CreateAndSellNFts.vue'
import InnerCollector from '@/components/MainHome/InnerCollector.vue'
import { ref, onMounted } from 'vue'

const modal = ref(false); // По умолчанию попап скрыт

const openModal = () => {
  modal.value = false;
  const now = new Date();
  localStorage.setItem('cookieModalClosed', now.getTime()); // Сохраняем время закрытия попапа
}
// Функция для проверки, прошло ли 24 часа с момента последнего закрытия попапа
const shouldShowModal = () => {
  const lastClosed = localStorage.getItem('cookieModalClosed');
  if (!lastClosed) return true; // Если попап ранее не закрывался, показываем его
  const now = new Date().getTime();
  const oneDay = 24 * 60 * 60 * 1000; // 24 часа в миллисекундах
  return now - lastClosed >= oneDay; // Показываем попап, если прошло 24 часа
}

onMounted(() => {
  if (shouldShowModal()) {
    modal.value = true; // Если прошло 24 часа или попап ранее не был закрыт, показываем его
  }
});
</script>

<template>
  <div class="main">
    <Hero />
    <MainTopNft />
    <TopCollection />
    <ExploreMarketplace />
    <InnerCollector />
    <CreateAndSellNFts />
    <div class="cookie-agreement" v-if="modal" ref="modal">
      <p class="cookie-agreement__text">
        Используя данный сайт, вы даете согласие на использование файлов cookie, данных об IP-адресе и местоположении, помогающих нам сделать его удобнее для вас.
        <router-link class="cookie-agreement__link" :to="{ name: 'cookie' }">Подробнее</router-link>
      </p>
      <button @click="openModal" class="btn-reset main-button cookie-agreement__btn">Accept and close</button>
    </div>
  </div>
</template>

<style lang="scss">
.cookie-agreement {
  position: fixed;
  bottom: 50px;
  left: 50px;
  max-width: 300px;
  padding: 25px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  gap: 20px;
  border-radius: 31px;
  box-shadow: 0 82px 82px -61px rgba(15, 15, 15, 0.1), 0 -82px 80px 0 rgba(0, 0, 0, 0.05);
  background: #ffffff;
  z-index: 1000000;
  &__text {
    margin: 0;
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 16px;
    line-height: 125%;
    color: #000;
  }
  &__btn {
    max-width: 100%;
    padding: 20px;
  }
  &__link {
    color: #000;
    text-decoration: underline;
  }
}
</style>
