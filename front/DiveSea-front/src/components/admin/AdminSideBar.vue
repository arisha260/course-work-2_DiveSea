<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();
</script>

<template>
  <nav class="nav admin-panel__nav">
    <ul class="list-reset nav__list admin-panel__list">
      <!-- Используем route.name для проверки активного маршрута и добавления класса на li -->
      <li class="nav__item" :class="{ active: route.name === 'admin-panel-approval-nfts' }">
        <router-link :to="{ name: 'admin-panel-approval-nfts' }" class="nav__link">Approve NFTs</router-link>
      </li>
      <li class="nav__item" :class="{ active: route.name === 'admin-panel-approval-authorship' }">
        <router-link :to="{ name: 'admin-panel-approval-authorship' }" class="nav__link">Approve Authorship</router-link>
      </li>
      <li class="nav__item" :class="{ active: route.name === 'admin-panel-terms' }">
        <router-link :to="{ name: 'admin-panel-approval-nfts' }" class="nav__link">Terms</router-link>
      </li>
    </ul>
  </nav>
</template>

<style scoped lang="scss">
.nav {
  &__list {
    display: flex;
    flex-direction: column;
    gap: 30px;
    align-items: flex-start;
  }
  &__item {
    width: 100%;
    border-bottom: 2px solid #ebe9e9;
    transition: all 0.3s ease;
    @media (hover: hover) {
      &:hover {
        transform: translateX(-10px);
      }
    }
    &.active {
      border-color: #000000;
    }
  }

  &__link {
    display: block;
    font-family: var(--second-family);
    font-weight: 500;
    font-size: 17px;
    line-height: 150%;
    text-transform: uppercase;
    color: #606060;
    position: relative;
    &::after{
      content: "";
      position: absolute;
      inset: 0;
    }
  }
}

.router-link-exact-active {
  color: #000000;
}
</style>
